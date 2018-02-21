<?php

namespace AppBundle\Repository;

/**
 * ClubJugadorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClubJugadorRepository extends \Doctrine\ORM\EntityRepository {

	public function getQbAll() {
		$qb = $this->createQueryBuilder( 'cj' );

		return $qb;
	}

	public function getQbByClub( $club ) {
		$qb = $this->createQueryBuilder( 'cj' );

		$qb->where( 'cj.club = :club' );
		$qb->andWhere( 'cj.anio = :anio' );
//		$qb->andWhere( 'cj.confirmado = true' );
//		$qb->andWhere( 'cj.confirmadoClub = false' );
//		$qb->orWhere( 'cj.confirmadoUnion = false' );

		$qb->setParameter( 'club', $club );
		$qb->setParameter( 'anio', date( 'Y' ) );


		return $qb;
	}

	public function getCountNuevosFichajes( $club ) {
		$qb = $this->createQueryBuilder( 'cj' );


		$qb->where( 'cj.club = :club' );
		$qb->andWhere( 'cj.anio = :anio' );
		$qb->andWhere( 'cj.confirmado = true' );
//		$qb->andWhere( 'cj.confirmadoClub = false' );
//		$qb->orWhere( 'cj.confirmadoUnion = false' );

		$qb->setParameter( 'club', $club );
		$qb->setParameter( 'anio', date( 'Y' ) );


		return $qb->getQuery()->getResult();
	}

	public function getCountJugadores( $club ) {
		$qb = $this->createQueryBuilder( 'cj' );


		$qb->where( 'cj.club = :club' );
		$qb->andWhere( 'cj.anio = :anio' );
		$qb->andWhere( 'cj.confirmado = true' );
		$qb->andWhere( 'cj.confirmadoClub = true' );
		$qb->andWhere( 'cj.confirmadoUnion = true' );

		$qb->setParameter( 'club', $club );
		$qb->setParameter( 'anio', date( 'Y' ) );


		return $qb->getQuery()->getResult();
	}

	public function getQbByUnion() {
		$qb = $this->createQueryBuilder( 'cj' );

		$qb->andWhere( 'cj.anio = :anio' );
		$qb->andWhere( 'cj.confirmado = true' );
		$qb->andWhere( 'cj.confirmadoClub = true' );
		$qb->andWhere( 'cj.confirmadoUnion = false' );

		$qb->setParameter( 'anio', date( 'Y' ) );


		return $qb;
	}
}
