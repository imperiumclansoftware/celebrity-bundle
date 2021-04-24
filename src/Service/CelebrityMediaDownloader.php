<?php
namespace ICS\CelebrityBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use ICS\CelebrityBundle\Entity\Celebrity;
use ICS\MediaBundle\Entity\MediaImage;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CelebrityMediaDownloader
{
    /**
     * HTTP Client
     *
     * @var Symfony\Component\HttpClient\HttpClientInterface
     */
    private $client;
    /**
     * Kernel
     *
     * @var Symfony\Component\HttpKernel\KernelInterface
     */
    private $kernel;
    /**
     * Slugger
     *
     * @var Symfony\Component\String\Slugger\SluggerInterface
     */
    private $slugger;
    /**
     * Doctrine
     *
     * @var Doctrine\ORM\EntityManagerInterface
     */
    private $doctrine;

    public function __construct(HttpClientInterface $client,EntityManagerInterface $doctrine, KernelInterface $kernel,SluggerInterface $slugger)
    {
        $this->client=$client;
        $this->kernel=$kernel;
        $this->slugger=$slugger;
        $this->doctrine=$doctrine;
    }
    public function downloadImage(Celebrity $celebrity,string $url,string $title)
    {
        $mediasDir=$this->kernel->getProjectDir().'/public/medias';
        $celebGalleryDir='celebrity/'.$this->slugger->slug($celebrity->getName()).'/gallery';
        $fulldir=$mediasDir.'/'.$celebGalleryDir;
        if(!is_dir($fulldir))
        {
            mkdir($fulldir,0775,true);
        }

        $response = $this->client->request(
            'GET',
            $url
        );

        $filename=$this->slugger->slug(strtolower($celebrity->getName())).'_'.str_pad((count($celebrity->getGallery()) + 1),5,"0",STR_PAD_LEFT);

        $fileHandler = fopen($fulldir.'/'.$filename, 'w');
        foreach ($this->client->stream($response) as $chunk) {
            fwrite($fileHandler, $chunk->getContent());
        }

        $extention=explode('/',mime_content_type($fulldir.'/'.$filename));
        $extention=$extention[1];

        rename($fulldir.'/'.$filename,$fulldir.'/'.$filename.'.'.$extention);

        $media=new MediaImage($this->kernel->getContainer());
        $media->load($fulldir.'/'.$filename.'.'.$extention,$celebGalleryDir);

        $celebrity->addToGallery($media);

        $this->doctrine->persist($celebrity);
        $this->doctrine->flush();

    }
}