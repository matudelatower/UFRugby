<?php

namespace App\Repository;

use App\Entity\TipoIncidencia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TipoIncidencia|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoIncidencia|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoIncidencia[]    findAll()
 * @method TipoIncidencia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoIncidenciaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TipoIncidencia::class);
    }

//    /**
//     * @return TipoIncidencia[] Returns an array of TipoIncidencia objects
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
    public function findOneBySomeField($value): ?TipoIncidencia
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
