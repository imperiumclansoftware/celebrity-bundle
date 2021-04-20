<?php

namespace ICS\CelebrityBundle\Controller;

use ICS\CelebrityBundle\Service\CelebrityNinja;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="ics-celebrity-homepage")
     */
    public function index(Request $request, CelebrityNinja $client)
    {
        $search = $request->get('search');
        $response=null;

        if($search!=null)
        {
            $response = $client->Search($search);
        }

        return $this->render('@Celebrity/index.html.twig', [
            'search' => $search,
            'response' => $response,
        ]);
    }
}
