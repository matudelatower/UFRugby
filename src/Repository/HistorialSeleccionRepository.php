<?php

namespace App\Repository;

use App\Entity\HistorialSeleccion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HistorialSeleccion|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistorialSeleccion|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistorialSeleccion[]    findAll()
 * @method HistorialSeleccion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistorialSeleccionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistorialSeleccion::class);
    }

//    /**
//     * @return HistorialSeleccion[] Returns an array of HistorialSeleccion objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HistorialSeleccion
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
