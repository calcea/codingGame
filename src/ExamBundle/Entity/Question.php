<?php

namespace ExamBundle\Entity;

use LessonBundle\Entity\Lesson;

class Question
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $question;

    /**
     * @var string
     */
    private $option1;

    /**
     * @var string
     */
    private $option2;

    /**
     * @var string
     */
    private $option3;

    /**
     * @var string
     */
    private $option4;

    /**
     * @var integer
     */
    private $answer;

    /**
     * @var Lesson
     */
    private $lesson;

    /**
     * @var integer
     */
    private $score;

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
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param string $question
     * @return Question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
        return $this;
    }

    /**
     * @return string
     */
    public function getOption1()
    {
        return $this->option1;
    }

    /**
     * @param string $option1
     * @return Question
     */
    public function setOption1($option1)
    {
        $this->option1 = $option1;
        return $this;
    }

    /**
     * @return string
     */
    public function getOption2()
    {
        return $this->option2;
    }

    /**
     * @param string $option2
     * @return Question
     */
    public function setOption2($option2)
    {
        $this->option2 = $option2;
        return $this;
    }

    /**
     * @return string
     */
    public function getOption3()
    {
        return $this->option3;
    }

    /**
     * @param string $option3
     * @return Question
     */
    public function setOption3($option3)
    {
        $this->option3 = $option3;
        return $this;
    }

    /**
     * @return string
     */
    public function getOption4()
    {
        return $this->option4;
    }

    /**
     * @param string $option4
     * @return Question
     */
    public function setOption4($option4)
    {
        $this->option4 = $option4;
        return $this;
    }

    /**
     * @return int
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param int $answer
     * @return Question
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
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
     * @param $lesson
     * @return $this
     */
    public function setLesson($lesson)
    {
        $this->lesson = $lesson;

        return $this;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param $score
     * @return $this
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    public function __toString()
    {
        if(!is_null($this->question)){
            return $this->question;
        }

        return '';
    }

}