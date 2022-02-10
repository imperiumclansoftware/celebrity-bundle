<?php

namespace ICS\CelebrityBundle\Controller;

use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Intl\Countries;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use ICS\MediaBundle\Entity\MediaImage;
use ICS\CelebrityBundle\Service\CelebrityNinja;
use ICS\CelebrityBundle\Entity\Celebrity;
use Doctrine\ORM\EntityManagerInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route("/addbysearch", name="ics-celebrity-addbysearch")
     */
    public function index(Request $request, CelebrityNinja $client)
    {
        $search = $request->get('search');
        $response=null;

        if($search!=null)
        {
            $response = $client->Search($search);
        }

        return $this->render('@Celebrity/search.html.twig', [
            'search' => $search,
            'response' => $response,
        ]);
    }

    /**
     * @Route("/", name="ics-celebrity-homepage")
     */
    public function slider(Request $request, EntityManagerInterface $em)
    {
        $celebs=$em->getRepository(Celebrity::class)->getSlider();
        $anniversaries = $em->getRepository(Celebrity::class)->getThisWeekAnniversary();
        $anniv=[];

        foreach($anniversaries as $ann)
        {
            $anniv[$ann->getBirthDay()->format('d-m')][]=$ann;
        }

        ksort($anniv);

        return $this->render('@Celebrity/index.html.twig', [
            'celebrities' => $celebs,
            'anniversaries' => $anniv
        ]);
    }

    /**
     * @Route("/stats", name="ics-celebrity-stats-nationality")
     */
    public function statsNationalyty(Request $request, EntityManagerInterface $em, TranslatorInterface $translator)
    {
        $nationalities = $em->getRepository(Celebrity::class)->getNbrByNationality();
        $data = [];
        
        foreach($nationalities as $nationality)
        {
            if(key_exists(strtoupper($nationality["nationality"]),Countries::getNames()))
            {
                $fullname = Countries::getName(strtoupper($nationality["nationality"]));
            }
            else
            {
                $fullname = 'Unknow';
            }
            $data[] = [
                'name' => strtolower($translator->trans($nationality["nationality"])),
                'fullname' => $fullname,
                'y' => $nationality["counter"]
            ];
        }

        return new JsonResponse($data);
    }
}
