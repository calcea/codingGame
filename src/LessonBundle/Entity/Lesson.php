<?php

namespace LessonBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Lesson
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $score_to_unlock;

    /**
     * @var string
     */
    private $title;

    /**
     * @var integer
     */
    private $chapter;

    /**
     * @var Language
     */
    private $language;

    /**
     * @var ArrayCollection
     */
    private $questions;

    /**
     * @var ArrayCollection
     */
    private $activities;

    /**
     * Lesson constructor.
     */
    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->activites = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Lesson
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getScoreToUnlock()
    {
        return $this->score_to_unlock;
    }

    /**
     * @param string $score_to_unlock
     * @return Lesson
     */
    public function setScoreToUnlock($score_to_unlock)
    {
        $this->score_to_unlock = $score_to_unlock;
        return $this;
    }

    /**
     * @return int
     */
    public function getChapter()
    {
        return $this->chapter;
    }

    /**
     * @param int $chapter
     * @return Lesson
     */
    public function setChapter($chapter)
    {
        $this->chapter = $chapter;
        return $this;
    }

    /**
     * @return Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param Language $language
     * @return Lesson
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     * @return Lesson
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @param $question
     * @return $this
     */
    public function addQuestion($question)
    {
        $this->questions->add($question);

        return $this;
    }

    /**
     * @param $question
     * @return $this
     */
    public function removeQuestion($question)
    {
        $this->questions->removeElement($question);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getActivities()
    {
        return $this->activities;
    }

    /**
     * @param $activity
     * @return $this
     */
    public function removeActivity($activity)
    {
        $this->activites->removeElement($activity);

        return $this;
    }

    /**
     * @param $activity
     * @return $this
     */
    public function addActivity($activity)
    {
        $this->activites->add($activity);

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if(!is_null($this->language) && !is_null($this->chapter) && !is_null($this->title)){
            return $this->title.' ( '.$this->language->getName().' - '.$this->chapter.' )';
        }

        return '';
    }

}