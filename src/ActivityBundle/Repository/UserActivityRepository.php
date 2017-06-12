<?php

namespace ActivityBundle\Repository;

use Doctrine\ORM\EntityRepository;
use LessonBundle\Entity\Language;
use UserBundle\Entity\User;

class UserActivityRepository extends EntityRepository
{
    public function getCountLessonFinished(Language $language, User $user)
    {
        $qb = $this->createQueryBuilder('userActivity')
            ->select('count(userActivity)')
            ->innerJoin('userActivity.lesson', 'lesson')
            ->where('lesson.language = :language AND userActivity.user = :user');

        $qb->setParameters(array('language' => $language, 'user' => $user));

        return $qb->getQuery()->getResult()[0][1];
    }

    public function getLanguageScoreForAnUser(Language $language, User $user)
    {
        $qb = $this->createQueryBuilder('userActivity')
            ->select('sum(userActivity.score)')
            ->innerJoin('userActivity.lesson', 'lesson')
            ->where('lesson.language = :language AND userActivity.user = :user');
        $qb->setParameters(array('language' => $language, 'user' => $user));

        return $qb->getQuery()->getResult()[0][1];
    }

    public function getTodayActivitties()
    {
        $dateObj = new \DateTime();
        $currentDate = $dateObj->format('Y-m-d');
        $qb = $this->createQueryBuilder('userActivity')
            ->select('userActivity')
            ->where('userActivity.startDate >= :date');

        $qb->setParameter('date', $currentDate);

        return $qb->getQuery()->getResult();
    }

    public function getActivitiesByLanguage(Language $language)
    {
        
        $queryBuilder = $this->createQueryBuilder("userActivity")
            ->select("userActivity")
            ->where("userActivity.lesson in (:lessons)")
            ->setParameter("lessons", $language->getLessons()->toArray());

        return $queryBuilder->getQuery()->getResult();
    }
}