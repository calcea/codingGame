<?php

namespace ActivityBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use LessonBundle\Entity\Language;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use UserBundle\Entity\User;

class Badge
{
    const SPEEDY_TYPE = 1;
    const MASTER_TYPE =2;

    const SPEEDY_TYPE_LABEL = "3 lectii cu procentaj maxim";
    const MASTER_TYPE_LABEL = "3 lectii complete intr-o zi";

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var UploadedFile
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
     * @var integer
     */
    private $type;

    /**
     * @var ArrayCollection
     */
    private $users;

    /**
     * @var Language
     */
    private $language;

    /**
     * Badge constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Badge
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param UploadedFile $logo
     * @return Badge
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
     * @param string $logoUrl
     * @return Badge
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
     * @param string $oldLogoUrl
     * @return Badge
     */
    public function setOldLogoUrl($oldLogoUrl)
    {
        $this->oldLogoUrl = $oldLogoUrl;
        return $this;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @param User $user
     * @param bool $updateRelation
     * @return $this
     */
    public function addUser(User $user, $updateRelation = true)
    {
        $this->users[] = $user;
        if ($updateRelation) {
            $user->addBadge($this, false);
        }

        return $this;
    }

    /**
     * @param User $user
     * @param bool $updateRelation
     *
     * @return $this;
     */
    public function removeUser(User $user, $updateRelation = true)
    {
        $this->users->removeElement($user);
        if($updateRelation){
            $user->removeBadge($this, false);
        }

        return $this;
    }

    /**
     * @param ArrayCollection $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }

    /**
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type =$type;

        return $this;
    }

    public function getTypeLabel()
    {
        return $this->getTypeLabels()[$this->getType];
    }

    /**
     * @return array
     */
    public static function getTypeLabels()
    {
        return array(
            self::SPEEDY_TYPE => self::SPEEDY_TYPE_LABEL,
            self::MASTER_TYPE => self::MASTER_TYPE_LABEL
        );
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if(!is_null($this->title)){
            return $this->title;
        }

        return '';
    }

}