<?php

namespace App\Entity;

use App\Entity\Interfaces\ContractInterface;
use App\Repository\ContractRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\InheritanceType;

/**
 * @ORM\Entity(repositoryClass=ContractRepository::class)
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"contract" = "Contract", "contractLesse" = "ContractLease", "contractOwnership" = "ContractOwnership"})
 */
abstract class Contract implements ContractInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $contractNumber;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $type;

    /**
     * @ORM\Column(type="string")
     */
    protected $contractStartDate;

    /**
     *
     * @ORM\OneToMany(targetEntity=Estate::class, mappedBy="contract",  cascade={"persist", "remove"})
     */
    protected $estates;


    const CONTRACT_LEASE_TYPE = 1;
    const CONTRACT_OWNERSHIP_TYPE = 2;

    /**
     * Contract constructor.
     * @param string $contractNumber
     * @param int $type
     * @param string $contractStartDate
     */
    public function __construct(string $contractNumber, int $type, string $contractStartDate)
    {
        $this->contractNumber = $contractNumber;
        $this->type = $type;
        $this->contractStartDate = $contractStartDate;

        $this->estates = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContractNumber(): ?string
    {
        return $this->contractNumber;
    }

    public function setContractNumber(string $contractNumber): self
    {
        $this->contractNumber = $contractNumber;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getContractStartDate(): ?string
    {
        return $this->contractStartDate;
    }

    public function setContractStartDate(string $contractStartDate): self
    {
        $this->contractStartDate = $contractStartDate;

        return $this;
    }

    /**
     * @return Collection|Estate[]
     */
    public function getEstates(): Collection
    {
        return $this->estates;
    }

    public function addEstate(Estate $estate): self
    {
        if (!$this->estates->contains($estate)) {
            $this->estates[] = $estate;
            $estate->setContract($this);
        }

        return $this;
    }

    public function removeEstate(Estate $estate): self
    {
        if ($this->estates->removeElement($estate)) {
            // set the owning side to null (unless already changed)
            if ($estate->getContract() === $this) {
                $estate->setContract(null);
            }
        }

        return $this;
    }
}
