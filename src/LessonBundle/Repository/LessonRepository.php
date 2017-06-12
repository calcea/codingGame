<?php

namespace LessonBundle\Repository;

use Doctrine\ORM\EntityRepository;
use LessonBundle\Entity\Language as LanguageEntity;

class LessonRepository extends EntityRepository
{
    public function getCountLessons(LanguageEntity $language)
    {
        $qb = $this->createQueryBuilder('lesson')
                    ->select('count(lesson)')
                    ->where('lesson.language = :language');

        $qb->setParameter('language', $language);

        return $qb->getQuery()->getResult()[0][1];
    }
}