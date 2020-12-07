<?php


namespace App\Factories\Interfaces;


use App\Entity\Estate;

interface EstateFactoryInterface
{
    /**
     * @param string $estateNumber
     * @param float $areaInAcre
     * @param array $landOwners
     * @return Estate
     */
    public function create(string $estateNumber, float $areaInAcre, array $landOwners): Estate;
}