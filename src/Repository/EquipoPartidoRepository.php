<?php

namespace App\Repository;

use App\Entity\EquipoPartido;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EquipoPartido|null find($id, $lockMode = null, $lockVersion = null)
 * @method EquipoPartido|null findOneBy(array $criteria, array $orderBy = null)
 * @method EquipoPartido[]    findAll()
 * @method EquipoPartido[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipoPartidoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EquipoPartido::class);
    }

//    /**
//     * @return EquipoPartido[] Returns an array of EquipoPartido objects
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
    public function findOneBySomeField($value): ?EquipoPartido
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
