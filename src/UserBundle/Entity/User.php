<?php

namespace UserBundle\Entity;

use ActivityBundle\Entity\Badge;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class User extends BaseUser
{

    /**
     * Default photo url.
     */
    const DEFAULT_PHOTO_URL = 'uploads/user_avatar/avatar-default.png';

    /**
     * User id.
     *
     * @var integer
     */
    protected $id;

    /**
     * User birthday.
     *
     * @var \DateTime
     */
    protected $birthday;

    /**
     * Avatar url.
     *
     * @var string
     */
    protected $avatarUrl;

    /**
     * Old avatar path.
     *
     * @var string
     */
    protected $oldAvatarUrl;

    /**
     * @var UploadedFile
     */
    protected $avatar;

    /**
     * @var ArrayCollection
     */
    private $activities;

    /**
     * @var ArrayCollection
     */
    private $badges;

    /**
     * @var ArrayCollection
     */
    private $correctQuestions;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->activities = new ArrayCollection();
        $this->badges = new ArrayCollection();
        $this->correctQuestions = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get user birthday.
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set user birthday.
     *
     * @param \DateTime $birthday
     * @return $this
     */
    public function setBirthday(\DateTime $birthday)
    {
        $this->birthday = $birthday;
        return $this;
    }

    /**
     * Get avatar url.
     *
     * @return string
     */
    public function getAvatarUrl()
    {
        if(!is_null($this->avatarUrl)){
            return $this->avatarUrl;
        }

        return self::DEFAULT_PHOTO_URL;
    }

    /**
     * Set avatarUrl.
     *
     * @param $avatarUrl
     * @return $this
     */
    public function setAvatarUrl($avatarUrl)
    {
        $this->oldAvatarUrl = $this->avatarUrl;
        $this->avatarUrl = $avatarUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getOldAvatarUrl()
    {
        return $this->oldAvatarUrl;
    }

    /**
     * @param string $oldAvatarUrl
     * @return User
     */
    public function setOldAvatarUrl($oldAvatarUrl)
    {
        $this->oldAvatarUrl = $oldAvatarUrl;
        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param UploadedFile $avatar
     * @return User
     */
    public function setAvatar($avatar = null)
    {
        $this->avatar = $avatar;
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
        $this->activities->removeElement($activity);

        return $this;
    }

    /**
     * @param $activity
     * @return $this
     */
    public function addActivity($activity)
    {
        $this->activities->add($activity);

        return $this;
    }

    /**
     * @param Badge $badge
     * @param bool $updateRelation
     * @return $this
     */
    public function removeBadge(Badge $badge, $updateRelation = true)
    {
        $this->badges->removeElement($badge);
        if($updateRelation){
            $badge->removeUser($this, false);
        }

        return $this;
    }

    /**
     * @param Badge $badge
     * @param bool $updateRelation
     * @return $this
     */
    public function addBadge(Badge $badge, $updateRelation = true)
    {
        $this->badges[] = $badge;
        if($updateRelation){
            $badge->addUser($this, false);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getBadges()
    {
        return $this->badges;
    }

    /**
     * @param ArrayCollection $badges
     * @return $this
     */
    public function setBadges($badges)
    {
        $this->badges = $badges;

        return $this;
    }

    /**
     * @param $correctQuestions
     * @return $this
     */
    public function setCorrectQuestions($correctQuestions)
    {
        $this->correctQuestions = $correctQuestions;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getCorrectQuestions()
    {
        return $this->correctQuestions;
    }

    /**
     * @param $correctQuestion
     * @return $this
     */
    public function addCorrectQuestion($correctQuestion)
    {
        $this->correctQuestions[] = $correctQuestion;

        return $this;
    }

    /**
     * @param $correctQuestion
     * @return $this
     */
    public function removeCorrectQuestion($correctQuestion)
    {
        $this->correctQuestions->removeElement($correctQuestion);

        return $this;
    }

    public function hasBadge(Badge $badge){
        return $this->badges->contains($badge);
    }

}

