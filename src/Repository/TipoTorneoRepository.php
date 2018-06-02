<?php

namespace App\Repository;

use App\Entity\TipoTorneo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TipoTorneo|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoTorneo|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoTorneo[]    findAll()
 * @method TipoTorneo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoTorneoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TipoTorneo::class);
    }

//    /**
//     * @return TipoTorneo[] Returns an array of TipoTorneo objects
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
    public function findOneBySomeField($value): ?TipoTorneo
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
