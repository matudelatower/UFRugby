<?php

namespace App\Repository;

use App\Entity\TiempoIncidencia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TiempoIncidencia|null find($id, $lockMode = null, $lockVersion = null)
 * @method TiempoIncidencia|null findOneBy(array $criteria, array $orderBy = null)
 * @method TiempoIncidencia[]    findAll()
 * @method TiempoIncidencia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TiempoIncidenciaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TiempoIncidencia::class);
    }

//    /**
//     * @return TiempoIncidencia[] Returns an array of TiempoIncidencia objects
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
    public function findOneBySomeField($value): ?TiempoIncidencia
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
