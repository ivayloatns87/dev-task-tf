<?php

namespace App\Entity;

use App\Repository\ContractTypeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContractTypeRepository::class)
 */
class ContractType
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
    private $contractTypeName;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getContractTypeName(): ?string
    {
        return $this->contractTypeName;
    }

    /**
     * @param string $contractTypeName
     * @return $this
     */
    public function setContractTypeName(string $contractTypeName): self
    {
        $this->contractTypeName = $contractTypeName;

        return $this;
    }
}
