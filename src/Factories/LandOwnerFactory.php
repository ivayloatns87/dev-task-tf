<?php


namespace App\Factories;


use App\Entity\LandOwner;

class LandOwnerFactory
{
    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $phone
     * @param string $id
     * @return LandOwner
     */
    public function create(string $firstName, string $lastName, string $phone, string $id): LandOwner
    {
        return new LandOwner($firstName, $lastName, $phone, $id);
    }
}