<?php

namespace App\Repository;

use App\Entity\InscripcionReferee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InscripcionReferee|null find($id, $lockMode = null, $lockVersion = null)
 * @method InscripcionReferee|null findOneBy(array $criteria, array $orderBy = null)
 * @method InscripcionReferee[]    findAll()
 * @method InscripcionReferee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InscripcionRefereeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InscripcionReferee::class);
    }

//    /**
//     * @return InscripcionReferee[] Returns an array of InscripcionReferee objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InscripcionReferee
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
