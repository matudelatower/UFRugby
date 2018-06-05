<?php

namespace App\Repository;

use Doctrine\ORM\Query\Expr;

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


		$qb->setParameter( 'club', $club );
		$qb->setParameter( 'anio', date( 'Y' ) );


		return $qb;
	}

	public function getQbRegistroJugadores( $club ) {
		$qb = $this->createQueryBuilder( 'cj' );

		$qb->where( 'cj.club = :club' );
		$qb->andWhere( 'cj.anio = :anio' );

		$qb->andWhere( 'cj.confirmadoClub = false' );
//		$qb->andWhere( 'cj.confirmadoUnion = false' );


		$qb->setParameter( 'club', $club );
		$qb->setParameter( 'anio', date( 'Y' ) );


		return $qb;
	}

	public function getCountNuevosFichajes( $club ) {
		$qb = $this->createQueryBuilder( 'cj' );


		$qb->where( 'cj.club = :club' );
		$qb->andWhere( 'cj.anio = :anio' );
		$qb->andWhere( 'cj.confirmado = true' );
		$qb->andWhere( 'cj.confirmadoClub = false' );
//		$qb->orWhere( 'cj.confirmadoUnion = false' );

		$qb->setParameter( 'club', $club );
		$qb->setParameter( 'anio', date( 'Y' ) );


		return $qb->getQuery()->getResult();
	}

	public function getCountAllNuevosFichajes() {
		$qb = $this->createQueryBuilder( 'cj' );
		$qb->select( 'COUNT(cj.id)' );


		$qb->andWhere( 'cj.anio = :anio' );
		$qb->setParameter( 'anio', date( 'Y' ) );

		$qb->andWhere('cj.confirmadoUnion = false');


		return $qb->getQuery()->getSingleScalarResult();
	}

	public function getCountAllJugadores() {
		$qb = $this->createQueryBuilder( 'cj' );
		$qb->select( 'COUNT(cj.id)' );


		$qb->andWhere( 'cj.anio = :anio' );
		$qb->andWhere( 'cj.confirmado = true' );
		$qb->andWhere( 'cj.confirmadoClub = true' );
		$qb->orWhere( 'cj.confirmadoUnion = true' );

		$qb->setParameter( 'anio', date( 'Y' ) );


		return $qb->getQuery()->getSingleScalarResult();
	}

	public function getCountJugadores( $club ) {
//		$qb = $this->createQueryBuilder( 'cj' );
//
//
//		$qb->where( 'cj.club = :club' );
//		$qb->andWhere( 'cj.anio = :anio' );
//		$qb->andWhere( 'cj.confirmado = true' );
//		$qb->andWhere( 'cj.confirmadoClub = true' );
//		$qb->andWhere( 'cj.confirmadoUnion = true' );
//
//		$qb->setParameter( 'club', $club );
//		$qb->setParameter( 'anio', date( 'Y' ) );
//
//
//		return $qb->getQuery()->getResult();


	}

	public function getQbByUnion() {
		$qb = $this->createQueryBuilder( 'cj' );

		$qb->select( 'cj.id' );

		$qb->andWhere( 'cj.anio = :anio' );

		$qb
			->andwhere( 'cj.confirmado = true' )
			->andwhere( 'cj.confirmadoClub = true' )
			->andwhere( 'cj.confirmadoUnion = true' );

		$qb2 = $this->createQueryBuilder( 'cj2' );
		$qb2->where(
			$qb2->expr()->notIn( 'cj2.id', $qb->getDQL() )
		);

		$qb2->setParameter( 'anio', date( 'Y' ) );


		return $qb2;
	}

	public function getCountAllJugadoresCompetitivos() {
		$qb = $this->createQueryBuilder( 'cj' );
		$qb->select( 'COUNT(cj.id)' );


		$qb->andWhere( 'cj.anio = :anio' );

		$qb->andWhere( 'cj.confirmadoUnion = true' );

		$qb->setParameter( 'anio', date( 'Y' ) );


		$endDate = new \DateTime( 'now' );
		$endDate->modify( '-14 years' );

		$qb->innerJoin( 'cj.jugador', 'jugador' )
		   ->innerJoin( 'jugador.persona', 'persona' )
		   ->andWhere( 'persona.fechaNacimiento < :anios' )
		   ->setParameter( 'anios', $endDate );

		return $qb->getQuery()->getSingleScalarResult();
	}

}
