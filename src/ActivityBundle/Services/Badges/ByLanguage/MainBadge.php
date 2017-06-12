<?php

namespace ActivityBundle\Services\Badges\ByLanguage;

use Doctrine\Bundle\DoctrineBundle\Registry;
use LessonBundle\Entity\Language;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use UserBundle\Entity\User;

/**
 * Date: 5/26/2016
 * Time: 19:00
 * @copyright (c) Zitec COM
 * @author George Calcea <george.calcea@zitec.com>
 */
abstract class MainBadge
{
    protected $name;

    protected $logoUrl;

    /**
     * Must be implemented into the child classes
     */
    const BADGE_TYPE = 0;

    /**
     * @var Registry
     */
    protected $doctrine;

    /**
     * @var TokenStorage
     */
    protected $securityContext;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Language
     */
    protected $language;

    protected $badgeId = null;

    protected $isNew = true;

    /**
     * ActivityTracking constructor.
     *
     * @param Registry $doctrine
     * @param TokenStorage $securityContext
     */
    public function __construct(Registry $doctrine, TokenStorage $securityContext, Language $language)
    {
        $this->doctrine = $doctrine;
        $this->securityContext = $securityContext;
        $this->user = $securityContext->getToken()->getUser();
        $this->language = $language;
        $this->badgeId = $this->getBadgeId();
        $this->initBadge();
    }

    protected function initBadge()
    {
        $badgesRepository = $this->doctrine->getRepository('ActivityBundle:Badge');
        $currentBadge = $badgesRepository->find($this->badgeId);
        if (!empty($currentBadge)) {
            $this->logoUrl = $currentBadge->getLogoUrl();
            $this->name = $currentBadge->getTitle();
        }
    }

    public function save()
    {
        $badgesRepository = $this->doctrine->getRepository('ActivityBundle:Badge');
        $currentBadge = $badgesRepository->find($this->badgeId);
        if ($this->user->hasBadge($currentBadge)) {
            $this->isNew = false;
            return;
        }
        $this->user->addBadge($currentBadge);
        $this->doctrine->getManager()->persist($this->user);
        $this->doctrine->getManager()->flush();
    }

    protected function getBadgeId()
    {
        $badgeRepo = $this->doctrine->getRepository("ActivityBundle:Badge");
        $badge = $badgeRepo->findBy(array("type" => static::BADGE_TYPE, "language" => $this->language))[0];

        return $badge->getId();
    }

    public function isNew()
    {
        return $this->isNew;
    }

}