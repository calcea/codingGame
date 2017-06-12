<?php
/**
 * Date: 5/26/2016
 * Time: 19:09
 * @copyright (c) Zitec COM
 * @author George Calcea <george.calcea@zitec.com>
 */

namespace ActivityBundle\Services\Badges\ByLanguage;


use Doctrine\Bundle\DoctrineBundle\Registry;
use LessonBundle\Entity\Language;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use UserBundle\Entity\User;

class BadgeByLanguageKernel
{

    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @var TokenStorage
     */
    private $securityContext;

    /**
     * @var User
     */
    private $user;

    /**
     * @var Language
     */
    private $language;

    /**
     * @var array
     */
    private $badges;

    /**
     * ActivityTracking constructor.
     *
     * @param Registry $doctrine
     * @param TokenStorage $securityContext
     */
    public function __construct(Registry $doctrine, TokenStorage $securityContext, Language $language)
    {
        $this->language = $language;
        $this->doctrine = $doctrine;
        $this->securityContext = $securityContext;
        $this->user = $securityContext->getToken()->getUser();
        $this->initBadges();
    }

    private function initBadges()
    {
        $this->badges[] = new MasterBadge($this->doctrine, $this->securityContext, $this->language);
        $this->badges[] = new SpeedyBadge($this->doctrine, $this->securityContext, $this->language);
    }

    public function getTodayActiveBadges()
    {
        $badges = array();
        foreach ($this->badges as $badge) {
            /* @var $badge MasterBadge | SpeedyBadge */
            if ($badge->isAvailable() && $badge->isNew()) {
                $badges[] = $badge->toArray();
            }
        }
        return $badges;
    }
}