<?php
/**
 * Date: 5/25/2016
 * Time: 19:32
 * @copyright (c) Zitec COM
 * @author George Calcea <george.calcea@zitec.com>
 */

namespace LessonBundle\Services;


use Doctrine\Bundle\DoctrineBundle\Registry;
use ExamBundle\Entity\Question;

class QuestionService
{
    private $doctrineManager = null;
    private $userQuestionRepository = null;
    private $questionsRepository = null;

    /**
     * LessonService constructor.
     * @param Registry $doctrine
     */
    public function __construct(Registry $doctrine)
    {
        $this->doctrineManager = $doctrine;
        $this->userQuestionRepository = $doctrine->getRepository('ActivityBundle:UserQuestion');
        $this->questionsRepository = $doctrine->getRepository('ExamBundle:Question');
    }

    public function isCorrectAnswered(Question $question)
    {
        $userQuestion = $this->userQuestionRepository->findBy(array('question' => $question));
        return !empty($userQuestion);
    }
}