<?php

namespace ICS\CelebrityBundle\Controller;

use Exception;
use ICS\CelebrityBundle\Entity\Celebrity;
use ICS\CelebrityBundle\Entity\Occupation;
use ICS\CelebrityBundle\Form\Type\CelebrityType;
use ICS\CelebrityBundle\Service\CelebrityMediaDownloader;
use ICS\CelebrityBundle\Service\CelebrityNinja;
use ICS\MediaBundle\Entity\MediaImage;
use ICS\QwantBundle\Service\QwantService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class CelebrityController extends AbstractController
{
    /**
     * @Route("/add/{celebrityName}", name="ics-celebrity-add")
     * @Route("/edit/{id}", name="ics-celebrity-edit")
     */
    public function add(CelebrityNinja $client, Request $request, $celebrityName=null,Celebrity $celebrity=null)
    {
        $em= $this->getDoctrine()->getManager();
        $editMode=true;
        if($celebrity==null)
        {
            $celebrity=new Celebrity();
            $editMode=false;
        }
        if($celebrityName!=null)
        {
            $response = $client->Search($celebrityName);
            if(count($response)==1)
            {
                $celebrity=Celebrity::FromCelebrityResult($response[0]);

                $occupations=clone($celebrity->getOccupation());
                $celebrity->getOccupation()->clear();
                // Update Occupations
                foreach($occupations as $occupation)
                {
                    $occ=$this->getDoctrine()->getRepository(Occupation::class)->findOneBy(['code' => $occupation->getCode()]);
                    if($occ==null)
                    {
                        $occ=new Occupation();
                        $occ->setCode($occupation->getCode());
                        $em->persist($occ);
                        $em->flush();
                    }

                    $celebrity->getOccupation()->add($occ);
                }

                $em->persist($celebrity);
                $em->flush();

                return $this->redirectToRoute('ics-celebrity-show',['id' => $celebrity->getId()]);
            }
        }

        $form=$this->createForm(CelebrityType::class,$celebrity);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $celebrity=$form->getData();

            $em->persist($celebrity);
            $em->flush();

            return $this->redirectToRoute('ics-celebrity-show',['id' => $celebrity->getId()]);
        }

        return $this->render('@Celebrity/edit.html.twig', [
            'celebrity' => $celebrity,
            'editMode' => $editMode,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="ics-celebrity-show")
     */
    public function show(Celebrity $celebrity)
    {
        return $this->render('@Celebrity/show.html.twig', [
            'celebrity' => $celebrity,
        ]);
    }

    /**
     * @Route("/list", name="ics-celebrity-list")
     */
    public function list()
    {
        $celebrities=$this->getDoctrine()
        ->getRepository(Celebrity::class)
        ->findBy([],['name' => 'ASC']);

        $index=[];
        foreach($celebrities as $celebrity)
        {
            $index[strtoupper(substr($celebrity->getName(),0,1))][]=$celebrity;
        }

        return $this->render('@Celebrity/list.html.twig',[
            'index' => $index
        ]);
    }

    /**
     * @Route("/part/gallery/{id}", name="ics-celebrity-gallery")
     */
    public function showGallery(Celebrity $celebrity)
    {
        return $this->render('@Celebrity/gallery.html.twig',[
            'celebrity'=>$celebrity
        ]);
    }

    /**
     * @Route("/part/gallery/search/{id}", name="ics-celebrity-gallery-search")
     */
    public function searchGallery(Request $request, Celebrity $celebrity)
    {

        return $this->render('@Celebrity/gallery.html.twig',[
            'celebrity'=>$celebrity
        ]);
    }

    /**
     * @Route("/part/gallery/search/result/{page}", name="ics-celebrity-gallery-search-result")
     */
    public function searchResultGallery(Request $request,QwantService $service,$page=0)
    {
        $search=$request->get('search');
        $celebId=$request->get('id');

        if($search!=null)
        {
            $result = $service->Search($search,100,$page,'images');

            return $this->render("@Celebrity/search/searchResult.html.twig",[
                'results' => $result->data->result->items,
                'search' => $search,
                'downloadUrl' => $this->generateUrl('ics-celebrity-gallery-add',['id' => $celebId])
            ]);
        }

        return $this->createNotFoundException('No search');
    }

    /**
     * @Route("/part/gallery/add/{id}", name="ics-celebrity-gallery-add")
     */
    public function addGallery(Request $request, CelebrityMediaDownloader $downloader ,Celebrity $celebrity)
    {
        $title=$request->get('title');
        $url=$request->get('url');

        try
        {
            $downloader->downloadImage($celebrity,$url,$title);
        }
        catch(Exception $ex)
        {
            return $this->createNotFoundException($ex->getMessage());
        }

        return new Response('ok');
    }

    /**
     * @Route("/part/representative/set", name="ics-celebrity-representative-set")
     */
    public function setRepresentative(Request $request,KernelInterface $kernel)
    {
        $assetDir=$kernel->getProjectDir().'/public';
        $celebrity=$this->getDoctrine()->getRepository(Celebrity::class)->find((int)$request->get('celebrity'));
        $media= $this->getDoctrine()->getRepository(MediaImage::class)->findOneBy([
            'path' => $assetDir.$request->get('source')
        ]);

        if($celebrity!=null && $media!=null)
        {
            $celebrity->setRepresentative($media);
            $em=$this->getDoctrine()->getManager();
            $em->persist($celebrity);
            $em->flush();

            return new Response('ok');
        }

        return new Response('ko');
    }
}
