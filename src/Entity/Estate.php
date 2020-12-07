<?php

namespace App\Entity;

use App\Repository\EstateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EstateRepository::class)
 */
class Estate
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $estateNumber;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $areaInAcre;

    /**
     * @ORM\ManyToOne(targetEntity=Contract::class, inversedBy="estates")
     */
    private $contract;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\LandOwner", inversedBy="users", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="land_owner_estate",
     *     joinColumns={@ORM\JoinColumn(name="estate_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="land_owner_id", referencedColumnName="id")}
     * )
     */
    private $landOwners;

    const SHARE_PERCENTAGE_REQUIRED_OVER_ESTATE_OWNER_COUNT = 1;
    const MAX_SHARE_PERCENT = 100;

    /**
     * Estate constructor.
     * @param string $estateNumber
     * @param float $areaInAcre
     */
    public function __construct(string $estateNumber, float $areaInAcre)
    {

        $this->estateNumber = $estateNumber;
        $this->areaInAcre = $areaInAcre;
        $this->landOwners = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEstateNumber(): ?string
    {
        return $this->estateNumber;
    }

    public function setEstateNumber(string $estateNumber): self
    {
        $this->estateNumber = $estateNumber;

        return $this;
    }

    public function getAreaInAcre(): ?string
    {
        return $this->areaInAcre;
    }

    public function setAreaInAcre(string $areaInAcre): self
    {
        $this->areaInAcre = $areaInAcre;

        return $this;
    }

    public function getContract(): ?Contract
    {
        return $this->contract;
    }

    public function setContract(?Contract $contract): self
    {
        $this->contract = $contract;

        return $this;
    }

    /**
     * @return Collection|LandOwner[]
     */
    public function getLandOwners()
    {
        return $this->landOwners;
    }

    /**
     * @param LandOwner $landOwner
     * @return $this
     */
    public function addLandOwner(LandOwner $landOwner): self
    {
        if (!$this->landOwners->contains($landOwner)) {
            $this->landOwners[] = $landOwner;
            $landOwner->addEstate($this);
        }

        return $this;
    }

    /**
     * @param LandOwner $landOwner
     * @return $this
     */
    public function removeLandOwner(LandOwner $landOwner): self
    {
        if ($this->landOwners->removeElement($landOwner)) {
            $landOwner->removeRole($this);
        }

        return $this;
    }
}
