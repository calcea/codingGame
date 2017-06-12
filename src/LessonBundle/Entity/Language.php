<?php

namespace LessonBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;

class Language
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var File
     */
    private $logo;

    /**
     * @var string
     */
    private $logoUrl;

    /**
     * @var string
     */
    private $oldLogoUrl;

    /**
     * @var ArrayCollection
     */
    private $lessons;

    /**
     * @var ArrayCollection
     */
    private $badges;


    public function __construct()
    {
        $this->badges = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getBadges()
    {
        return $this->badges;
    }

    public function setBadges($badges)
    {
        $this->badges = $badges;

        return $this;
    }

    public function addBadge($badge)
    {
        $this->badges->add($badge);

        return $this;
    }

    public function removeBadge($badge)
    {
        $this->badges->removeElement($badge);

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Language
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return File
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param $logo
     * @return $this
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogoUrl()
    {
        return $this->logoUrl;
    }

    /**
     * @param $logoUrl
     * @return $this
     */
    public function setLogoUrl($logoUrl)
    {
        $this->oldLogoUrl = $this->logoUrl;
        $this->logoUrl = $logoUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getOldLogoUrl()
    {
        return $this->oldLogoUrl;
    }

    /**
     * @return ArrayCollection
     */
    public function getLessons()
    {
        return $this->lessons;
    }

    /**
     * @param Lesson $lesson
     * @return $this
     */
    public function addLesson(Lesson $lesson)
    {
        $this->lessons[] = $lesson;

        return $this;
    }

    /**
     * @param Lesson $lesson
     * @return $this
     */
    public function removeLesson(Lesson $lesson)
    {
        $this->lessons->removeElement($lesson);

        return $this;
    }

    public function __toString()
    {
        if(isset($this->name)){
            return $this->name;
        }

        return '';
    }
}