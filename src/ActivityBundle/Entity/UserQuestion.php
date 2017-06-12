<?php

namespace ActivityBundle\Entity;

use ExamBundle\Entity\Question;
use UserBundle\Entity\User;

class UserQuestion
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var User
     */
    private $user;

    /**
     * @var Question
     */
    private $question;

    /**
     * @var \DateTime
     */
    private $time;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @return UserQuestion
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param Question $question
     * @return UserQuestion
     */
    public function setQuestion($question)
    {
        $this->question = $question;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param \DateTime $time
     * @return UserQuestion
     */
    public function setTime($time)
    {
        $this->time = $time;
        return $this;
    }


}