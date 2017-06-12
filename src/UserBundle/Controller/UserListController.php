<?php

namespace UserBundle\Controller;

use ActivityBundle\Entity\Badge;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class UserListController extends Controller
{
    public function listAction(Request $request)
    {
        $userRepo = $this->getDoctrine()->getRepository('UserBundle:User');
        $users = $userRepo->findAll();

        $xp = $this->calculateUsersXp($users);
        foreach ($xp as $userId => $xpUser) {
            $encodeXp[$userId] = json_encode($xpUser);
        }
        $badges = $this->getBadges($users);


        return $this->render('UserBundle:List:list_users.html.twig',
            array('users' => $users, 'xp' => $encodeXp, 'badges' => $badges));
    }

    public function showAction(Request $request, $id)
    {
        $user = $this->getDoctrine()->getManager()->getRepository('UserBundle:User')->find($id);
        $userXp = $this->get('userbundle.user_experience')->getXpForAnUser($user);

        return $this->render('UserBundle:List:show_user.html.twig', array('user' => $user, 'xp' => $userXp));
    }

    protected function getBadges($users)
    {
        $badges = array();
        foreach ($users as $user) {
            $userBadges = $user->getBadges();
            $badgesTemp = array();
            foreach ($userBadges as $badge) {
                /* @var $badge Badge */
                $tempArr['badge_language'] = $badge->getLanguage()->getName();
                $tempArr['badge_title'] = $badge->getTitle();
                $tempArr['badge_logo_url'] = $badge->getLogoUrl();
                $tempArr['badge_id'] = $badge->getId();
                $badgesTemp[$badge->getId()] = $tempArr;
            }

            $badges[$user->getId()] = json_encode($badgesTemp);
        }

        return $badges;
    }

    /**
     * Calculate user experience for each language.
     *
     * @param $users
     * @return array
     */
    protected function calculateUsersXp($users)
    {
        $usersXp = array();
        $usersXpService = $this->get('userbundle.user_experience');

        foreach ($users as $user) {
            $usersXp[$user->getId()] = $usersXpService->getXpForAnUser($user);
        }

        return $usersXp;
    }
}