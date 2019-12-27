<?php

namespace App\Repository;

use App\Entity\RondaTorneo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RondaTorneo|null find($id, $lockMode = null, $lockVersion = null)
 * @method RondaTorneo|null findOneBy(array $criteria, array $orderBy = null)
 * @method RondaTorneo[]    findAll()
 * @method RondaTorneo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RondaTorneoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RondaTorneo::class);
    }

//    /**
//     * @return RondaTorneo[] Returns an array of RondaTorneo objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RondaTorneo
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
