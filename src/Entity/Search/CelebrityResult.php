<?php

namespace ICS\CelebrityBundle\Entity\Search;

class CelebrityResult
{
    private $name;
    private $birthday;
    private $deathday;
    private $age;
    private $height;
    private $netWorth;
    private $nationality;
    private $occupation;
    private $imageUrl;

    public function __construct($celebrityNinjaData)
    {
        $this->name = $celebrityNinjaData->name;
        if (property_exists($celebrityNinjaData, 'birthday')) {
            $this->birthday = $celebrityNinjaData->birthday;
        }
        if (property_exists($celebrityNinjaData, 'deathday')) {
            $this->deathday = $celebrityNinjaData->deathday;
        }
        if (property_exists($celebrityNinjaData, 'age')) {
            $this->age = $celebrityNinjaData->age;
        }
        if (property_exists($celebrityNinjaData, 'height')) {
            $this->height = $celebrityNinjaData->height;
        }
        if (property_exists($celebrityNinjaData, 'net_worth')) {
            $this->netWorth = $celebrityNinjaData->net_worth;
        }
        if (property_exists($celebrityNinjaData, 'nationality')) {
            $this->nationality = $celebrityNinjaData->nationality;
        }
        if (property_exists($celebrityNinjaData, 'occupation')) {
            $this->occupation = $celebrityNinjaData->occupation;
        }
    }

    /**
     * Get the value of name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name.
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of birthday.
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set the value of birthday.
     *
     * @return self
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get the value of deathday.
     */
    public function getDeathday()
    {
        return $this->deathday;
    }

    /**
     * Set the value of deathday.
     *
     * @return self
     */
    public function setDeathday($deathday)
    {
        $this->deathday = $deathday;

        return $this;
    }

    /**
     * Get the value of age.
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set the value of age.
     *
     * @return self
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get the value of height.
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set the value of height.
     *
     * @return self
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get the value of netWorth.
     */
    public function getNetWorth()
    {
        return $this->netWorth;
    }

    /**
     * Set the value of netWorth.
     *
     * @return self
     */
    public function setNetWorth($netWorth)
    {
        $this->netWorth = $netWorth;

        return $this;
    }

    /**
     * Get the value of nationality.
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * Set the value of nationality.
     *
     * @return self
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * Get the value of occupation.
     */
    public function getOccupation()
    {
        return $this->occupation;
    }

    /**
     * Set the value of occupation.
     *
     * @return self
     */
    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;

        return $this;
    }

    /**
     * Get the value of imageUrl.
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * Set the value of imageUrl.
     *
     * @return self
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }
}
