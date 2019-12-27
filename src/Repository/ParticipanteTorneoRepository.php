<?php

namespace App\Repository;

use App\Entity\ParticipanteTorneo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ParticipanteTorneo|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParticipanteTorneo|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParticipanteTorneo[]    findAll()
 * @method ParticipanteTorneo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipanteTorneoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ParticipanteTorneo::class);
    }

//    /**
//     * @return ParticipanteTorneo[] Returns an array of ParticipanteTorneo objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ParticipanteTorneo
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
