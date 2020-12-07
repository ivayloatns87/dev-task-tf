<?php

namespace App\Repository;

use App\Entity\ContractOwnership;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContractOwnership|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContractOwnership|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContractOwnership[]    findAll()
 * @method ContractOwnership[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractOwnershipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContractOwnership::class);
    }

    public function getUserEstates()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT 
                contract.id AS contract_id,
                estates.id AS estate_id,
                contract.contractNumber,
                estates.estateNumber,
                estates.areaInAcre,
                contract.contractStartDate,
                contract.price,
                (contract.price / estates.areaInAcre) AS pricePerAcre
             FROM 
                App\Entity\ContractOwnership AS contract
             LEFT JOIN
                contract.estates AS estates
             WHERE 
                estates.id IS NOT NULL     
             GROUP BY 
                estates.id          
             '
        );

        $data = $query->getResult();

        return $data;
    }
}
