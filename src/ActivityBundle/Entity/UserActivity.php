<?php

namespace ActivityBundle\Entity;

use LessonBundle\Entity\Lesson;
use UserBundle\Entity\User;

class UserActivity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var float
     */
    private $score;

    /**
     * @var User
     */
    private $user;

    /**
     * @var Lesson
     */
    private $lesson;

    /**
     * @var \DateTime
     */
    private $startDate;

    /**
     * UserActivity constructor.
     *
     * Set current timestamp when persist object.
     */
    public function __construct()
    {
        if(is_null($this->startDate)){
            $this->startDate = new \DateTime();
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param float $score
     * @return UserActivity
     */
    public function setScore($score)
    {
        $this->score = $score;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return UserActivity
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Lesson
     */
    public function getLesson()
    {
        return $this->lesson;
    }

    /**
     * @param Lesson $lesson
     * @return UserActivity
     */
    public function setLesson($lesson)
    {
        $this->lesson = $lesson;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param $startDate
     * @return $this
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }
}