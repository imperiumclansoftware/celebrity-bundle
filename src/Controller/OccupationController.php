<?php

namespace ICS\CelebrityBundle\Controller;

use ICS\CelebrityBundle\Entity\Celebrity;
use ICS\CelebrityBundle\Entity\Occupation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OccupationController extends AbstractController
{
    /**
     * @Route("/occupation/{id}", name="ics-celebrity-occupation")
     */
    public function index(Occupation $occupation)
    {
        $occupations=$this->getDoctrine()
                        ->getRepository(Occupation::class)
                        ->findBy([],['code' => 'ASC']);

        return $this->render('@Celebrity/occupation.html.twig', [
            'occupation' => $occupation,
            'occupations' => $occupations,
        ]);
    }
}
