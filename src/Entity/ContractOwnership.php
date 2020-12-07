<?php

namespace App\Entity;

use App\Entity\Interfaces\OwnershipInterface;
use App\Repository\ContractOwnershipRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContractOwnershipRepository::class)
 */
class ContractOwnership extends Contract implements OwnershipInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;

    public function __construct(string $contractNumber, int $type, string $contractStartDate, float $price)
    {
        parent::__construct($contractNumber, $type, $contractStartDate);
        $this->price = $price;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }
}
