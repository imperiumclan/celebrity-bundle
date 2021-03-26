<?php

namespace ICS\CelebrityBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="celebrities")
 *
 * @ApiResource(
 *     collectionOperations={"get"},
 *     itemOperations={"get"}
 * )
 * @ApiFilter(SearchFilter::class, properties={"id":"exact", "fullname":"partial", "name":"partial", "surname":"partial"})
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
     * @ORM\Column(type="string", nullable=true)
     */
    private $name;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $surname;
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $fullname;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthDay;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deathDay;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $biography;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $nationality;

    /**
     * @ORM\ManyToOne(targetEntity="ICS\MediaBundle\Entity\MediaImage", cascade={"persist","remove"})
     */
    private $representative;


    /**
     * @ORM\ManyToMany(targetEntity="ICS\MediaBundle\Entity\MediaImage", cascade={"persist","remove"})
     */
    private $gallery;

    public function __construct()
    {
        $this->gallery = new ArrayCollection();
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
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
     * Get the value of surname
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set the value of surname
     *
     * @return  self
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get the value of fullname
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Get the value of birthDay
     */
    public function getBirthDay()
    {
        return $this->birthDay;
    }

    /**
     * Set the value of birthDay
     *
     * @return  self
     */
    public function setBirthDay($birthDay)
    {
        $this->birthDay = $birthDay;

        return $this;
    }

    /**
     * Get the value of deathDay
     */
    public function getDeathDay()
    {
        return $this->deathDay;
    }

    /**
     * Set the value of deathDay
     *
     * @return  self
     */
    public function setDeathDay($deathDay)
    {
        $this->deathDay = $deathDay;

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

    /**
     * Set undocumented variable
     *
     * @param  [type]  $fullname  Undocumented variable
     *
     * @return  self
     */
    public function setFullname(string $fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getAge()
    {
        if ($this->birthDay == null) {
            return null;
        }
        $now = new DateTime();
        $exactlyAge = $now->diff($this->birthDay);

        return $exactlyAge->format('%Y');
    }

    /**
     *
     */
    public function getGallery()
    {
        return $this->gallery;
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
     * Get
     */
    public function getRepresentative()
    {
        return $this->representative;
    }

    /**
     * Set
     * @return  self
     */
    public function setRepresentative($representative)
    {
        $this->representative = $representative;

        return $this;
    }
}
