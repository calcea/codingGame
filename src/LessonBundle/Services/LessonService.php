<?php

namespace LessonBundle\Services;

use ActivityBundle\Entity\UserQuestion;
use ActivityBundle\Services\ActivityTracking;
use Assetic\Asset\AssetCache;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\DBAL\Exception\InvalidArgumentException;
use ExamBundle\Entity\Question;
use LessonBundle\Entity\Lesson;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Created by PhpStorm.
 * User: george
 * Date: 4/20/2016
 * Time: 2:32 PM
 */
class LessonService
{

    private $doctrineManager = null;
    private $lessonRepository = null;
    private $activityTraking = null;
    private $tokenStorage  = null;

    /**
     * LessonService constructor.
     * @param Registry $doctrine
     */
    public function __construct(Registry $doctrine, ActivityTracking $activityTracking, TokenStorage $tokenStorage)
    {
        $this->doctrineManager = $doctrine;
        $this->lessonRepository = $doctrine->getRepository('LessonBundle:Lesson');
        $this->activityTraking = $activityTracking;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param $id
     * @return \LessonBundle\Entity\Lesson|object
     */
    public function getLessonById($id)
    {
        return $this->lessonRepository->find($id);
    }

    public function questionIsCorrect(Question $question, $answer)
    {
        if ($question->getAnswer() == $answer) {
            return true;
        }
        return false;
    }

    /**
     * @param $questionId
     * @param $option
     * @return Question|object
     * @throws InvalidArgumentException
     */
    public function saveQuestionResponse($questionId, $option)
    {
        if (empty($questionId) || empty($option)) {
            throw new InvalidArgumentException('The question id or option is empty!');
        }
        $questionRepository = $this->doctrineManager->getRepository('ExamBundle:Question');
        $question = $questionRepository->find($questionId);
        /*TODO test if the question has a previous correct answer*/
        if ($this->questionIsCorrect($question, $option)) {
            $this->logCorrectQuestion($question);
            $this->activityTraking->addQuestionToActivity($question);
        }
        return $question;
    }

    public function getLessonTotalScore(Lesson $lesson){
        return $this->activityTraking->getLessonScore($lesson, $this->tokenStorage->getToken()->getUser());
    }

    /**
     * Log in data store correct answer.
     *
     * @param Question $question
     */
    public function logCorrectQuestion(Question $question)
    {
        $em = $this->doctrineManager->getManager();

        $userQuestion = new UserQuestion();
        $userQuestion->setUser($this->tokenStorage->getToken()->getUser());
        $userQuestion->setQuestion($question);
        $userQuestion->setTime(new \DateTime());

        $em->persist($userQuestion);
        $em->flush();
    }
}