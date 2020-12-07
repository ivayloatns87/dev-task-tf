<?php


namespace App\Factories;


use App\Entity\Interfaces\ContractInterface;
use DateTime;

interface ContractFactoryInterface
{
    /**
     * @param string $contractNumber
     * @param int $type
     * @param DateTime $contractStartDate
     * @return ContractInterface
     */
    public function create(string $contractNumber, int $type, DateTime $contractStartDate) : ContractInterface;
}