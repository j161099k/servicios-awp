<?php

namespace App\Repository;

use App\Entity\ServiceStage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ServiceStage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceStage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceStage[]    findAll()
 * @method ServiceStage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceStageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceStage::class);
    }

    // /**
    //  * @return ServiceStage[] Returns an array of ServiceStage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ServiceStage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
