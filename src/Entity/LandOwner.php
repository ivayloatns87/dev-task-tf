<?php

namespace App\Entity;

use App\Repository\LessorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LandOwnerRepository::class)
 * @ORM\Table(name="land_owners")
 */
class LandOwner
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length= 50, unique=true)
     */
    private $personalIdentificationNumber;

    /**
     * @ORM\Column (type="integer", nullable=true)
     */
    private $sharePercent;


    /**
     * @ORM\ManyToMany (targetEntity="App\Entity\Estate", mappedBy="landOwners")
     *
     */
    private $estates;

    /**
     * LandOwnerRepository constructor.
     * @param string $firstName
     * @param string $lastName
     * @param string $phone
     * @param string $personalIdentificationNumber
     */
    public function __construct(string $firstName, string $lastName, string $phone, string $personalIdentificationNumber)
    {

        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phone = $phone;
        $this->personalIdentificationNumber = $personalIdentificationNumber;

        $this->estates = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPersonalIdentificationNumber(): ?int
    {
        return $this->personalIdentificationNumber;
    }

    public function setPersonalIdentificationNumber(int $personalIdentificationNumber): self
    {
        $this->personalIdentificationNumber = $personalIdentificationNumber;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getEstates()
    {
        return $this->estates;
    }

    /**
     * @param Estate $estate
     * @return $this
     */
    public function addEstate(Estate $estate): self
    {
        $this->estates[] = $estate;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSharePercent()
    {
        return $this->sharePercent;
    }

    /**
     * @param int $sharePercent
     * @return $this
     */
    public function setSharePercent(int $sharePercent): self
    {
        $this->sharePercent = $sharePercent;

        return $this;
    }
}
