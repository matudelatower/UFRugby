<?php

namespace App\Repository;

use App\Entity\FechaRonda;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FechaRonda|null find($id, $lockMode = null, $lockVersion = null)
 * @method FechaRonda|null findOneBy(array $criteria, array $orderBy = null)
 * @method FechaRonda[]    findAll()
 * @method FechaRonda[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FechaRondaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FechaRonda::class);
    }

//    /**
//     * @return FechaRonda[] Returns an array of FechaRonda objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FechaRonda
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
