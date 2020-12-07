<?php


namespace App\Factories;


use App\Entity\Estate;
use App\Entity\LandOwner;
use App\Factories\Interfaces\EstateFactoryInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class EstateFactory implements EstateFactoryInterface
{
    /**
     * @param string $estateNumber
     * @param float $areaInAcre
     * @param array $landOwners
     * @return Estate
     */
    public function create(string $estateNumber, float $areaInAcre, array $landOwners): Estate
    {
        /** @var Estate $estate */
        $estate = new Estate($estateNumber, $areaInAcre);

        /** @var LandOwner $landOwner */
        foreach ($landOwners as $landOwner) {
            $estate->addLandOwner($landOwner);
        }

        return $estate;
    }
}