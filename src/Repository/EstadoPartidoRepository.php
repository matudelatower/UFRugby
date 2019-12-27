<?php

namespace App\Repository;

use App\Entity\EstadoPartido;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EstadoPartido|null find($id, $lockMode = null, $lockVersion = null)
 * @method EstadoPartido|null findOneBy(array $criteria, array $orderBy = null)
 * @method EstadoPartido[]    findAll()
 * @method EstadoPartido[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstadoPartidoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EstadoPartido::class);
    }

//    /**
//     * @return EstadoPartido[] Returns an array of EstadoPartido objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EstadoPartido
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
