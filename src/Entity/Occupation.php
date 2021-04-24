<?php

namespace ICS\CelebrityBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ICS\SsiBundle\Annotation\Log;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="celebrity")
 * @Log(actions={"all"},property="logMessage")
*/
class Occupation
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
    private $code;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $femalelib;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $malelib;
    /**
     * @ORM\ManyToMany(targetEntity="ICS\CelebrityBundle\Entity\Celebrity", mappedBy="occupation",cascade={"persist","remove"})
     */
    private $celebrities;


    public function __construct()
    {
        $this->celebrities= new ArrayCollection();
    }

    /**
     * Get the value of code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @return  self
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get the value of femalelib
     */
    public function getFemalelib()
    {
        return $this->femalelib;
    }

    /**
     * Set the value of femalelib
     *
     * @return  self
     */
    public function setFemalelib($femalelib)
    {
        $this->femalelib = $femalelib;

        return $this;
    }

    /**
     * Get the value of malelib
     */
    public function getMalelib()
    {
        return $this->malelib;
    }

    /**
     * Set the value of malelib
     *
     * @return  self
     */
    public function setMalelib($malelib)
    {
        $this->malelib = $malelib;

        return $this;
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
        return $this->getCode().' (#'.$this->getId().')';
    }

    public function __toString()
    {
        if($this->getMalelib()!="")
        {
            return $this->getMalelib();
        }

        return $this->getCode();
    }

    /**
     * Get the value of celebrities
     */
    public function getCelebrities()
    {
        return $this->celebrities;
    }
}