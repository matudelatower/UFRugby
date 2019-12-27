<?php

namespace App\Repository;

use App\Entity\MiembroEquipoPartido;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MiembroEquipoPartido|null find($id, $lockMode = null, $lockVersion = null)
 * @method MiembroEquipoPartido|null findOneBy(array $criteria, array $orderBy = null)
 * @method MiembroEquipoPartido[]    findAll()
 * @method MiembroEquipoPartido[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MiembroEquipoPartidoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MiembroEquipoPartido::class);
    }

//    /**
//     * @return MiembroEquipoPartido[] Returns an array of MiembroEquipoPartido objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MiembroEquipoPartido
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
