<?php


namespace App\Entity\Interfaces;


interface UserInterface
{
    public function signContract(int $contractType, array $data);
}