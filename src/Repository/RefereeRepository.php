<?php

namespace App\Repository;

use App\Entity\Referee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Referee|null find( $id, $lockMode = null, $lockVersion = null )
 * @method Referee|null findOneBy( array $criteria, array $orderBy = null )
 * @method Referee[]    findAll()
 * @method Referee[]    findBy( array $criteria, array $orderBy = null, $limit = null, $offset = null )
 */
class RefereeRepository extends ServiceEntityRepository {
	public function __construct( ManagerRegistry $registry ) {
		parent::__construct( $registry, Referee::class );
	}

//    /**
//     * @return Referee[] Returns an array of Referee objects
//     */
	/*
	public function findByExampleField($value)
	{
		return $this->createQueryBuilder('r')
			->andWhere('r.exampleField = :val')
			->setParameter('val', $value)
			->orderBy('r.id', 'ASC')
			->setMaxResults(10)
			->getQuery()
			->getResult()
		;
	}
	*/

	/*
	public function findOneBySomeField($value): ?Referee
	{
		return $this->createQueryBuilder('r')
			->andWhere('r.exampleField = :val')
			->setParameter('val', $value)
			->getQuery()
			->getOneOrNullResult()
		;
	}
	*/

	public function findQbAll() {
		return $this->createQueryBuilder( 'r' );
	}

	public function findQbBuscar( $data ) {
		$qb = $this->findQbAll();

		if ( $data ) {

			if (isset($data['nombre'])){
				$nombre = $data['nombre'];

				$qb->join('r.persona', 'persona');

				$qb
					->where( "upper(persona.nombre) like upper(:nombre)" );
				$qb->setParameter( 'nombre', '%' . $nombre . '%' );
			}

			if (isset($data['apellido'])){
				$apellido = $data['apellido'];

				$qb->join('r.persona', 'persona');

				$qb
					->where( "upper(persona.apellido) like upper(:apellido)" );
				$qb->setParameter( 'apellido', '%' . $apellido . '%' );
			}

			if (isset($data['numeroIdentificacion'])){
				$numeroIdentificacion = $data['numeroIdentificacion'];

				$qb->join('r.persona', 'persona');

				$qb
					->where( "upper(persona.numeroIdentificacion) like upper(:numeroIdentificacion)" );
				$qb->setParameter( 'numeroIdentificacion', '%' . $numeroIdentificacion . '%' );
			}

		}

		return $qb;
	}
}
