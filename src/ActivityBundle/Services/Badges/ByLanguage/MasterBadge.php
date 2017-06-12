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
use LessonBundle\Entity\Lesson;
use Proxies\__CG__\ActivityBundle\Entity\Badge;

class MasterBadge extends MainBadge implements BadgeInterface
{
    const BADGE_TYPE = 2;

    const LESSON_TO_UNLOCK = 5;

    public function isAvailable()
    {
        $lessonUnlocked = 0;
        $activities = $this->getActivitiesByLanguage();
        $scoreUntilToday = $this->getScoreByLanguageUntilToday($activities);
        $totalScore = $this->getTotalScoreByActivities($activities);
        foreach ($this->language->getLessons() as $lesson) {
            /* @var $lesson Lesson */
            if ($lesson->getScoreToUnlock() != 0 && $lesson->getScoreToUnlock() > $scoreUntilToday && $lesson->getScoreToUnlock() <= $totalScore) {
                $lessonUnlocked++;
            }
        }
        if ($lessonUnlocked >= self::LESSON_TO_UNLOCK) {
            $this->save();
            return true;
        }
        return false;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'logo_url' => $this->logoUrl,
            'language' => $this->language->getName(),
            'message' => ''
        ];
    }


    private function getActivitiesByLanguage()
    {
        $activityRepo = $this->doctrine->getRepository("ActivityBundle:UserActivity");
        return $activityRepo->getActivitiesByLanguage($this->language);
    }

    private function getScoreByLanguageUntilToday(array $activities)
    {
        $score = 0;
        $dateObj = new \DateTime();
        $currentDate = $dateObj->format('Y-m-d');
        foreach ($activities as $activity) {
            /* @var $activity UserActivity */
            if ($activity->getStartDate() < $currentDate) {
                $score += $activity->getScore();
            }
        }

        return $score;
    }

    private function getTotalScoreByActivities(array $activities)
    {
        $score = 0;
        foreach ($activities as $activity) {
            /* @var $activity UserActivity */
            $score += $activity->getScore();
        }

        return $score;
    }

}