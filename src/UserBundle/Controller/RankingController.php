<?php
/**
 * Created by PhpStorm.
 * User: Naty
 * Date: 5/27/2016
 * Time: 6:57 PM
 */

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RankingController extends Controller
{
    /**
     * Show ranking.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showRankingAction(Request $request)
    {
        $userXpServices = $this->get('userbundle.user_experience');

        $users = $this->getDoctrine()->getRepository('UserBundle:User')->findAll();
        $languages = $this->getDoctrine()->getRepository('LessonBundle:Language')->findAll();

        foreach($users as $user)
        {
            $userName = $user->getUsername();
            $usersId[$userName] = $user->getId();
            $userXp = $userXpServices->getXpForAnUser($user);
            $userXp['total'] = $this->calculateTotalXp($userXp);
            $xpUsers[$userName] = $userXp;
        }
        uasort($xpUsers,array($this, 'compareXp'));

        return $this->render('UserBundle:Ranking:show.html.twig', array('xp' => $xpUsers, 'usersId' => $usersId ,'languages' => $languages));
    }

    /**
     * @param array $a
     * @param array $b
     * @return int
     */
    protected function compareXp($a, $b)
    {
        if($a['total'] == $b['total']){
            return 0;
        }

        return ($a['total'] < $b['total']) ? 1 : -1;
    }

    /**
     * @param array $userXps
     * @return int
     */
    protected function calculateTotalXp($userXps)
    {
        $totalXp = 0;
        foreach($userXps as $userXp){
            $totalXp += $userXp;
        }

        return$totalXp;
    }
}