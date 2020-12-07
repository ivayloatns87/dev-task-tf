<?php

namespace App\Entity;

use App\Entity\Interfaces\LeaseInterface;
use App\Repository\ContractLeaseRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContractLeaseRepository::class)
 */
class ContractLease extends Contract implements LeaseInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    public $contractEndDate;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    public $rentPerAcre;



    public function __construct(string $contractNumber, int $type, string $contractStartDate, string $contractEndDate, float $rentPerAcre)
    {
        parent::__construct($contractNumber, $type, $contractStartDate);
        $this->contractEndDate = $contractEndDate;
        $this->rentPerAcre = $rentPerAcre;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContractEndDate(): ?string
    {
        return $this->contractEndDate;
    }

    public function setContractEndDate(string $contractEndDate): self
    {
        $this->contractEndDate = $contractEndDate;

        return $this;
    }

    public function getRentPerAcre(): ?string
    {
        return $this->rentPerAcre;
    }

    public function setRentPerAcre(string $rentPerAcre): self
    {
        $this->rentPerAcre = $rentPerAcre;

        return $this;
    }
}
