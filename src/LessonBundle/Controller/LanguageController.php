<?php
namespace LessonBundle\Controller;

use ActivityBundle\Services\ActivityTracking;
use ActivityBundle\Services\Badges\ByLanguage\BadgeByLanguageKernel;
use Doctrine\ORM\EntityRepository;
use LessonBundle\Entity\Language;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LanguageController extends Controller
{

    public function showAllAction(Request $request)
    {
        /** @var EntityRepository $languageRepo */
        $languageRepo = $this->getDoctrine()->getManager()->getRepository('LessonBundle:Language');

        $languages = $languageRepo->findAll();

        $user = $this->container->get('security.context')->getToken()->getUser();
        $twigParameters = array('languages' => $languages);
        if(!is_null($user) && $user != 'anon.'){
            $scores = $this->mappedScoreForLanguage($languages, $user);
            $twigParameters['scores'] = $scores;
        }

        return $this->render('LessonBundle:Language:show_all.html.twig',$twigParameters);
    }

    public function showAction(Request $request, $id)
    {
        /** @var EntityRepository $languageRepo */
        $languageRepo = $this->getDoctrine()->getManager()->getRepository('LessonBundle:Language');

        $language = $languageRepo->find($id);
        return $this->render('LessonBundle:Language:show.html.twig', array('language' => $language,
            'activityTracking' => new ActivityTracking($this->getDoctrine(), $this->get('security.token_storage') )));
    }

    /**
     * @param array $languages
     *
     * @return array
     */
    private function mappedScoreForLanguage($languages, $user)
    {
        $activityService = $this->get('activity_bundle.services.activity_tracking');
        $languageScores = array();
        /** @var Language $language */
        foreach($languages as $language)
        {
            $languageScores[$language->getId()] = $activityService->getLanguagePercentage($language, $user);
        }

        return $languageScores;
    }
}