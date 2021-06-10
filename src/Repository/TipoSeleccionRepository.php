<?php

namespace App\Repository;

use App\Entity\TipoSeleccion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TipoSeleccion|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoSeleccion|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoSeleccion[]    findAll()
 * @method TipoSeleccion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoSeleccionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoSeleccion::class);
    }

//    /**
//     * @return TipoSeleccion[] Returns an array of TipoSeleccion objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TipoSeleccion
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
