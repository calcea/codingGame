<?php
namespace ActivityBundle\Services;

use ActivityBundle\Entity\UserActivity;
use Doctrine\Bundle\DoctrineBundle\Registry;
use ExamBundle\Entity\Question;
use LessonBundle\Entity\Language;
use LessonBundle\Entity\Lesson;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use UserBundle\Entity\User;

class ActivityTracking
{
    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @var TokenStorage
     */
    private $securityContext;

    /**
     * ActivityTracking constructor.
     *
     * @param Registry $doctrine
     */
    public function __construct(Registry $doctrine, TokenStorage $securityContext)
    {
        $this->doctrine = $doctrine;
        $this->securityContext = $securityContext;
    }

    /**
     * Return score for an exam for current user.
     *
     * @param Lesson $lesson
     * @param User $user
     * @return int
     */
    public function getLessonScore(Lesson $lesson, User $user)
    {
        $activityRepo = $this->doctrine->getManager()->getRepository('ActivityBundle:UserActivity');
        /** @var UserActivity $activity */
        $activity = $activityRepo->findBy(array('user' => $user, 'lesson' => $lesson));
        if (empty($activity)) {
            return 0;
        }
        return $activity[0]->getScore();
    }

    /**
     * @param Language $language
     * @param User $user
     * @return float|int
     */
    public function getLanguagePercentage(Language $language, User $user)
    {
        $lessonRepo = $this->doctrine->getManager()->getRepository('LessonBundle:Lesson');
        $numberOfLessons = $lessonRepo->getCountLessons($language);

        $userActivityRepo = $this->doctrine->getManager()->getRepository('ActivityBundle:UserActivity');
        $numberOfFinishedLessons = $userActivityRepo->getCountLessonFinished($language, $user);

        if (empty($numberOfFinishedLessons) || empty($numberOfLessons)) {
            return 0;
        }

        return floatval($numberOfFinishedLessons / $numberOfLessons * 100);
    }

    /**
     * @param Language $language
     * @param User $user
     * @return mixed
     */
    public function getLanguageScore(Language $language, User $user)
    {
        $userActivityRepo = $this->doctrine->getManager()->getRepository('ActivityBundle:UserActivity');

        return $userActivityRepo->getLanguageScoreForAnUser($language, $user);
    }

    /**
     * Returns the total score for a lesson
     *
     * @param Language $language
     * @return float|int
     */
    public function getLanguageTotalScore(Language $language, User $user){
        $score = 0;
        $lessonsRepo = $this->doctrine->getRepository('LessonBundle:Lesson');
        $lessons = $lessonsRepo->findBy(array('language' => $language));
        foreach ($lessons as $lesson) {
            $score += $this->getLessonScore($lesson, $user);
        }

        return $score;
    }

    /**
     * Adds the question score to the current activity
     *
     * @param Question $question
     */
    public function addQuestionToActivity(Question $question)
    {
        $user = $this->securityContext->getToken()->getUser();

        $currentScore = $this->getLessonScore($question->getLesson(), $user);
        $totalScore = $currentScore + $question->getScore();
        $activityRepo = $this->doctrine->getRepository('ActivityBundle:UserActivity');
        $activity = $activityRepo->findBy(array('user' => $user, 'lesson' => $question->getLesson()));

        if (empty($activity)) {
            $activity = new UserActivity();
            $activity->setUser($user);
            $activity->setLesson($question->getLesson());
        } else {
            $activity = $activity[0];
        }
        /** @var UserActivity $activity */
        $activity->setScore($totalScore);

        $this->doctrine->getEntityManager()->persist($activity);
        $this->doctrine->getEntityManager()->flush();

    }
}