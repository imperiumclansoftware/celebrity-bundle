<?php

namespace ICS\CelebrityBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use ICS\CelebrityBundle\Entity\Search\CelebrityResult;
use Doctrine\ORM\Mapping as ORM;
use ICS\MediaBundle\Entity\MediaImage;
use ICS\SsiBundle\Annotation\Log;
use PhpParser\Node\Expr\Cast\Array_;

/**
 * @ORM\Entity(repositoryClass="ICS\CelebrityBundle\Repository\CelebrityRepository")
 * @ORM\Table(schema="celebrity")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @Log(actions={"all"},property="logMessage")
 */
class Celebrity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;
    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $gender;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthday;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deathday;
    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $height;
    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $netWorth;
    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $nationality;
    /**
     * @ORM\ManyToMany(targetEntity="ICS\CelebrityBundle\Entity\Occupation",inversedBy="celebrities",cascade={"persist","remove"})
     */
    private $occupation;
    /**
     * @ORM\ManyToOne(targetEntity="ICS\MediaBundle\Entity\MediaImage",cascade={"persist","remove"})
     */
    private $representative;
    /**
     * @ORM\ManyToMany(targetEntity="ICS\MediaBundle\Entity\MediaImage",cascade={"persist","remove"})
     */
    private $gallery;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $biography;

    public function __construct()
    {
        $this->occupation=new ArrayCollection();
        $this->gallery=new ArrayCollection();

    }

    public static function FromCelebrityResult(CelebrityResult $result)
    {
        $celebrity=new Celebrity();
        $celebrity->setName($result->getName())
                ->setGender($result->getGender())
                ->setBirthday($result->getBirthday())
                ->setDeathday($result->getDeathday())
                ->setHeight($result->getHeight())
                ->setNetWorth($result->getNetWorth())
                ->setNationality(strtoupper($result->getNationality()))
        ;

        foreach($result->getOccupation() as $occupation)
        {
            $occ=new Occupation();
            $occ->setCode($occupation);
            $celebrity->getOccupation()->add($occ);
        }

        return $celebrity;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of gender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set the value of gender
     *
     * @return  self
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get the value of birthday
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set the value of birthday
     *
     * @return  self
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get the value of deathday
     */
    public function getDeathday()
    {
        return $this->deathday;
    }

    public function getAge()
    {
        if($this->getBirthday()!=null)
        {
            if($this->getDeathday()!=null)
            {
                $diff= $this->getDeathday()->diff($this->getBirthday());

            }
            else
            {
                $now=new DateTime();
                $diff=$now->diff($this->getBirthday());
            }

            return $diff->y;
        }

        return null;
    }

    /**
     * Set the value of deathday
     *
     * @return  self
     */
    public function setDeathday($deathday)
    {
        $this->deathday = $deathday;

        return $this;
    }

    /**
     * Get the value of height
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set the value of height
     *
     * @return  self
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get the value of netWorth
     */
    public function getNetWorth()
    {
        return $this->netWorth;
    }

    /**
     * Set the value of netWorth
     *
     * @return  self
     */
    public function setNetWorth($netWorth)
    {
        $this->netWorth = $netWorth;

        return $this;
    }

    /**
     * Get the value of nationality
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * Set the value of nationality
     *
     * @return  self
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * Get the value of occupation
     */
    public function getOccupation()
    {
        return $this->occupation;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Return message for log
     *
     * @return string
     */
    public function getLogMessage() : string
    {
        return $this->getName().' (#'.$this->getId().')';
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set the value of occupation
     *
     * @return  self
     */
    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;

        return $this;
    }

    /**
     * Get the value of representative
     */
    public function getRepresentative()
    {
        return $this->representative;
    }

    /**
     * Set the value of representative
     *
     * @return  self
     */
    public function setRepresentative($representative)
    {
        $this->representative = $representative;

        return $this;
    }

    /**
     * Get the value of gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * Set the value of gallery
     *
     * @return  self
     */
    public function setGallery($gallery)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get the value of biography
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * Set the value of biography
     *
     * @return  self
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;

        return $this;
    }

    public function addToGallery(MediaImage $image)
    {
        if(!$this->gallery->contains($image))
        {
            $this->gallery->add($image);
        }
    }
}