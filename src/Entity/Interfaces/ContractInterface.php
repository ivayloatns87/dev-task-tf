<?php


namespace App\Entity\Interfaces;


interface ContractInterface
{
    public function getContractNumber();
    public function getContractStartDate();
    public function getType();
}