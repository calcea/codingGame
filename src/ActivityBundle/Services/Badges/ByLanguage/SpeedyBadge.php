<?php
/**
 * Date: 5/26/2016
 * Time: 19:13
 * @copyright (c) Zitec COM
 * @author George Calcea <george.calcea@zitec.com>
 */

namespace ActivityBundle\Services\Badges\ByLanguage;


use ActivityBundle\Entity\UserActivity;
use ActivityBundle\Services\Badges\BadgeInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;
use ExamBundle\Entity\Question;
use LessonBundle\Entity\Lesson;

class SpeedyBadge extends MainBadge implements BadgeInterface
{
    const BADGE_TYPE = 1;

    const MIN_LANGUAGES_COMPLETED_TODAY = 3;

    /**
     * @return bool
     */
    public function isAvailable()
    {
        $lessonsCompletedToday = 0;
        $lessonsStartedToday = $this->getAllLessonsStartedToday();

        foreach ($lessonsStartedToday as $activity) {
            if ($activity->getLesson()->getLanguage() != $this->language) {
                continue;
            }
            $totalLessonScore = $this->getLessonTotalScore($activity->getLesson());
            /* @var $activity UserActivity */
            if ($activity->getScore() == $totalLessonScore) {
                $lessonsCompletedToday++;
            }
        }

        if ($lessonsCompletedToday >= self::MIN_LANGUAGES_COMPLETED_TODAY) {
            $this->save();
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'name' => $this->name,
            'logo_url' => $this->logoUrl,
            'language' => $this->language->getName(),
            'message' => ''
        ];
    }

    /**
     * @param Lesson $lesson
     * @return int
     */
    private function getLessonTotalScore(Lesson $lesson)
    {
        $totalScore = 0;
        foreach ($lesson->getQuestions() as $question) {
            /* @var $question Question */
            $totalScore += $question->getScore();
        }
        return $totalScore;
    }

    /**
     * @return \ActivityBundle\Entity\UserActivity[]|array
     */
    private function getAllLessonsStartedToday()
    {
        $activityRepo = $this->doctrine->getRepository("ActivityBundle:UserActivity");
        $activities = $activityRepo->getTodayActivitties();

        return $activities;
    }
}