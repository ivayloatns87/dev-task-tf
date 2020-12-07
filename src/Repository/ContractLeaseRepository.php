<?php

namespace App\Repository;

use App\Entity\ContractLease;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContractLease|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContractLease|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContractLease[]    findAll()
 * @method ContractLease[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractLeaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContractLease::class);
    }

    public function getDueRent()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT 
                contract.id AS contract_id,
                estates.id AS estate_id,
                contract.contractNumber,
                contract.contractStartDate,
                contract.contractEndDate,
                contract.contractNumber,
                estates.estateNumber,
                estates.areaInAcre,
                land_owners.firstName,    
                contract.rentPerAcre,
                land_owners.sharePercent,
                land_owners.id AS owner_id,
                (SELECT                
                     CASE 
                        when 
                            lo.sharePercent = 0 
                        then 
                             SUM(c.rentPerAcre *  e.areaInAcre)
                        else 
                          SUM(c.rentPerAcre *   (lo.sharePercent / 100 *  e.areaInAcre))
                     END as total
                     FROM 
                        App\Entity\ContractLease AS c
                     LEFT JOIN
                        c.estates AS e
                     LEFT JOIN 
                        e.landOwners AS lo
                ) AS estate_total_rate,
                CASE 
                    when 
                        land_owners.sharePercent = 0 
                    then 
                        100
                    else 
                        land_owners.sharePercent
                END as sharePercent,
                CASE 
                    when 
                        land_owners.sharePercent = 0 
                    then 
                         estates.areaInAcre
                    else 
                      (land_owners.sharePercent / 100 *  estates.areaInAcre)
                END as shareInAcre,
                CASE 
                    when 
                        land_owners.sharePercent = 0 
                    then 
                         contract.rentPerAcre *  estates.areaInAcre
                    else 
                      contract.rentPerAcre *   (land_owners.sharePercent / 100 *  estates.areaInAcre)
                END as rentPerOwner
             FROM 
                App\Entity\ContractLease AS contract
             LEFT JOIN
                contract.estates AS estates
             LEFT JOIN 
                estates.landOwners AS land_owners
             WHERE 
                estates.id IS NOT NULL     
             GROUP BY
                land_owners.id,    
                estates.id          
             '
        );

        $data = $query->getResult();

        return $data;

    }
}
