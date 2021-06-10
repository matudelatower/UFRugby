<?php

namespace App\Repository;

use App\Entity\Club;
use App\Entity\Pase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pase|null find( $id, $lockMode = null, $lockVersion = null )
 * @method Pase|null findOneBy( array $criteria, array $orderBy = null )
 * @method Pase[]    findAll()
 * @method Pase[]    findBy( array $criteria, array $orderBy = null, $limit = null, $offset = null )
 */
class PaseRepository extends ServiceEntityRepository {
	public function __construct( ManagerRegistry $registry ) {
		parent::__construct( $registry, Pase::class );
	}

//    /**
//     * @return Pase[] Returns an array of Pase objects
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
	public function findOneBySomeField($value): ?Pase
	{
		return $this->createQueryBuilder('p')
			->andWhere('p.exampleField = :val')
			->setParameter('val', $value)
			->getQuery()
			->getOneOrNullResult()
		;
	}
	*/

	public function findQbAll() {
		return $this->createQueryBuilder( 'p' )->andWhere('p.activo = true');
	}

	public function findQbPendientesUnion(  ) {
		$qb = $this->findQbAll();

		$qb->where('p.confirmacionClub is not null');
		$qb->andWhere("UPPER(p.estado) <> 'RECHAZADA'");

		return $qb;
	}

	public function findQbSolicitudesEnviadas( Club $club ) {
		$qb = $this->findQbAll();

		$qb->where( 'p.clubDestino = :club' );

		$qb->setParameter( 'club', $club );
//		   ->andWhere( 'p.activo = true' );

		return $qb;
	}

	public function findQbSolicitudesRecibidas( Club $club ) {
		$qb = $this->findQbAll();

		$qb->where( 'p.clubOrigen = :club' )
		   ->andWhere( 'p.activo = true' );

		$qb->setParameter( 'club', $club );

		return $qb;
	}
}
