<?php

namespace UserBundle\Services;

use ActivityBundle\Entity\UserActivity;
use Doctrine\Bundle\DoctrineBundle\Registry;
use LessonBundle\Entity\Language;
use UserBundle\Entity\User;

class UserXp
{
    /**
     * @var Registry
     */
    protected $doctrine;

    /**
     * UserXp constructor.
     * @param $doctrine
     */
    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param $user
     * @return array
     */
    public function getXpForAnUser($user)
    {
        $xp = array();
        $languages = $this->doctrine->getManager()->getRepository('LessonBundle:Language')->findAll();

        foreach ($languages as $language) {
            $xp[$language->getName()] = $this->getUserXpForALanguage($user, $language);
        }

        return $xp;
    }

    /**
     * @param $user
     * @param $language
     * @return int
     */
    public function getUserXpForALanguage(User $user,Language $language)
    {
        $xp = 0;
        /** @var UserActivity $activity */
        foreach($user->getActivities() as $activity){
            if($language == $activity->getLesson()->getLanguage()){
                $xp += $activity->getScore();
            }
        }

        return $xp;
    }
}