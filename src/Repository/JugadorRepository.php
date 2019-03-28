<?php

namespace App\Repository;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * JugadorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class JugadorRepository extends \Doctrine\ORM\EntityRepository {

	public function getQbAll() {
		$qb = $this->createQueryBuilder( 'j' );

		return $qb;
	}

	public function getJugadoresByClub( $club ) {
//		$qb = $this->createQueryBuilder( 'j' );

//		$qb->join( 'j.clubJugador', 'cj' )
//		   ->join( 'cj.club', 'c' );
//
//		$qb->where( 'c = :club' );
//		$qb->andWhere( 'cj.confirmadoUnion = true' );

		$qb = $this->createQueryBuilder( 'j' )
		           ->innerJoin( 'j.clubJugador', 'cj' )
		           ->leftJoin( 'j.clubJugador', 'cj2', Expr\Join::WITH, 'j = cj2.jugador AND cj.id <  cj2.id' )
		           ->where( 'cj2.id IS NULL' );

		$qb->andWhere( 'cj.club = :club' );
		$qb->setParameter( 'club', $club );
		$qb->andWhere( 'cj.confirmadoUnion = true' );


		return $qb;
	}

	public function getJugadores() {
		$qb = $this->createQueryBuilder( 'j' );

		$qb->join( 'j.clubJugador', 'cj' );

		$qb->andWhere( 'cj.confirmadoUnion = true' );

		return $qb;
	}

	public function getQbBuscarJugadores( $data ) {
		$qb = $this->createQueryBuilder( 'j' );

		$qb->join( 'j.clubJugador', 'cj' );

		$qb->andWhere( 'cj.confirmadoUnion = true' );
		$qb->andWhere( 'cj.confirmadoClub = true' );

		if ( isset( $data['numeroIdentificacion'] ) ) {
			$numeroIdentificacion = $data['numeroIdentificacion'];

			$qb->join( 'j.persona', 'persona' );

			$qb
				->where( "upper(persona.numeroIdentificacion) like upper(:numeroIdentificacion)" );
			$qb->setParameter( 'numeroIdentificacion', '%' . $numeroIdentificacion . '%' );
		} else {
			return [];
		}


		return $qb;
	}

	public function getQbBuscarJugadoresByClub( $club, $data ) {
		$qb = $this->createQueryBuilder( 'j' )
		           ->innerJoin( 'j.clubJugador', 'cj' )
		           ->leftJoin( 'j.clubJugador', 'cj2', Expr\Join::WITH, 'j = cj2.jugador AND cj.id <  cj2.id' )
		           ->where( 'cj2.id IS NULL' );


		$qb->andWhere( 'cj.confirmadoUnion = true' );


		$qb->join( 'j.persona', 'persona' );

		if ( isset( $data['nombre'] ) ) {

			$nombre = $data['nombre'];
			$qb
				->andWhere( "upper(persona.nombre) like upper(:nombre)" );
			$qb->setParameter( 'nombre', '%' . $nombre . '%' );
		}

		if ( isset( $data['apellido'] ) ) {

			$apellido = $data['apellido'];
			$qb
				->andWhere( "upper(persona.apellido) like upper(:apellido)" );
			$qb->setParameter( 'apellido', '%' . $apellido . '%' );
		}

		if ( isset( $data['numeroIdentificacion'] ) ) {
			$numeroIdentificacion = $data['numeroIdentificacion'];

			$qb
				->andWhere( "upper(persona.numeroIdentificacion) like upper(:numeroIdentificacion)" );
			$qb->setParameter( 'numeroIdentificacion', '%' . $numeroIdentificacion . '%' );
		}

		if ( isset( $data['posicion'] ) ) {
			$posicion = $data['posicion'];

			$qb->andWhere(
				$qb->expr()->orX(
					$qb->expr()->eq( 'j.posicionHabitual', ':posicionHabitual' ),
					$qb->expr()->eq( 'j.posicionAlternativa', ':posicionAlternativa' ),
					$qb->expr()->eq( 'j.segundaPosicionAlternativa', ':segundaPosicionAlternativa' )

				)
			);

			$qb->setParameter( 'posicionHabitual', $posicion );

			$qb->setParameter( 'segundaPosicionAlternativa', $posicion );

			$qb->setParameter( 'posicionAlternativa', $posicion );
		}

		$fechaDesde = new \DateTime( '1800-1-1' );
		$fechaHasta = new \DateTime( '2200-12-31' );
		if ( isset( $data['fechaNacimientoDesde'] ) ) {
			$fechaDesde = $data['fechaNacimientoDesde'];
		}
		if ( isset( $data['fechaNacimientoHasta'] ) ) {
			$fechaHasta = $data['fechaNacimientoHasta'];
		}

		$qb->andWhere( 'persona.fechaNacimiento between :desde AND :hasta' );
		$qb->setParameter( 'desde', $fechaDesde );
		$qb->setParameter( 'hasta', $fechaHasta );

		if ( isset( $data['categoria'] ) ) {
			$qb->join( 'cj.division', 'division' );
			$qb->andWhere( 'division.categoria = :categoria' );
			$qb->setParameter( 'categoria', $data['categoria'] );
		}


		$qb->andWhere( 'cj.club = :club' );
		$qb->setParameter( 'club', $club );


		return $qb;
	}

	public function getQbJugadoresUnion( $data ) {
		$qb = $this->createQueryBuilder( 'j' )
		           ->innerJoin( 'j.clubJugador', 'cj' )
		           ->leftJoin( 'j.clubJugador', 'cj2', Expr\Join::WITH, 'j = cj2.jugador AND cj.id <  cj2.id' )
		           ->where( 'cj2.id IS NULL' );


		$qb->andWhere( 'cj.confirmadoUnion = true' );


		$qb->join( 'j.persona', 'persona' );

		if ( isset( $data['nombre'] ) ) {

			$nombre = $data['nombre'];
			$qb
				->andWhere( "upper(persona.nombre) like upper(:nombre)" );
			$qb->setParameter( 'nombre', '%' . $nombre . '%' );
		}

		if ( isset( $data['apellido'] ) ) {

			$apellido = $data['apellido'];
			$qb
				->andWhere( "upper(persona.apellido) like upper(:apellido)" );
			$qb->setParameter( 'apellido', '%' . $apellido . '%' );
		}

		if ( isset( $data['numeroIdentificacion'] ) ) {
			$numeroIdentificacion = $data['numeroIdentificacion'];

			$qb
				->andWhere( "upper(persona.numeroIdentificacion) like upper(:numeroIdentificacion)" );
			$qb->setParameter( 'numeroIdentificacion', '%' . $numeroIdentificacion . '%' );
		}

		if ( isset( $data['posicion'] ) ) {
			$posicion = $data['posicion'];

			$qb->andWhere(
				$qb->expr()->orX(
					$qb->expr()->eq( 'j.posicionHabitual', ':posicionHabitual' ),
					$qb->expr()->eq( 'j.posicionAlternativa', ':posicionAlternativa' ),
					$qb->expr()->eq( 'j.segundaPosicionAlternativa', ':segundaPosicionAlternativa' )

				)
			);

			$qb->setParameter( 'posicionHabitual', $posicion );

			$qb->setParameter( 'segundaPosicionAlternativa', $posicion );

			$qb->setParameter( 'posicionAlternativa', $posicion );
		}

		$fechaDesde = new \DateTime( '1800-1-1' );
		$fechaHasta = new \DateTime( '2200-12-31' );
		if ( isset( $data['fechaNacimientoDesde'] ) ) {
			$fechaDesde = $data['fechaNacimientoDesde'];
		}
		if ( isset( $data['fechaNacimientoHasta'] ) ) {
			$fechaHasta = $data['fechaNacimientoHasta'];
		}

		$qb->andWhere( 'persona.fechaNacimiento between :desde AND :hasta' );
		$qb->setParameter( 'desde', $fechaDesde );
		$qb->setParameter( 'hasta', $fechaHasta );

		if ( isset( $data['categoria'] ) ) {
			$qb->join( 'cj.division', 'division' );
			$qb->andWhere( 'division.categoria = :categoria' );
			$qb->setParameter( 'categoria', $data['categoria'] );
		}

		if ( isset( $data['club'] ) ) {

			$club = $data['club'];

			$qb->andWhere( 'cj.club = :club' )
			   ->setParameter( 'club', $club );

		}

		$qb->leftJoin( 'j.historialSeleccions', 'hs' );

		if ( isset( $data['tipoSeleccion'] ) ) {

			$qb->andWhere( 'hs.seleccion = :tipoSeleccion' )
			   ->setParameter( 'tipoSeleccion', $data['tipoSeleccion'] );
		}

		if ( isset( $data['torneo'] ) ) {
			$torneo = $data['torneo'];

			$qb
				->andWhere( "upper(hs.torneo) like upper(:torneo)" );
			$qb->setParameter( 'torneo', '%' . $torneo . '%' );
		}

		return $qb;
	}

	public function getCountJuvenilesSobreMayores($anio) {

		$em = $this->getEntityManager();

//		mayores
//		$sql = 'SELECT count(persona.id) as mayores from persona
//		INNER JOIN jugador on persona.id = jugador.persona_id
//		WHERE YEAR(DATE_SUB(NOW(), INTERVAL TO_DAYS(persona.fecha_nacimiento) DAY)) > 18';
//
//
//		$stmt = $em->getConnection()
//		           ->prepare( $sql );
//
//		$stmt->execute();
//		$rstMayores = $stmt->fetchColumn( '0' );

// juveniles
		$sql2 = 'SELECT count(persona.id) as juveniles from persona
		INNER JOIN jugador on persona.id = jugador.persona_id
		INNER JOIN club_jugador on jugador.id = club_jugador.jugador_id
		WHERE  YEAR(DATE_SUB(NOW(), INTERVAL TO_DAYS(persona.fecha_nacimiento) DAY)) BETWEEN 14 and 18
		AND club_jugador.id in (Select max(cj.id) from club_jugador cj where cj.jugador_id = jugador.id)
		AND club_jugador.confirmado_union = TRUE
		AND club_jugador.anio= '. $anio;


		$stmt2 = $em->getConnection()
		            ->prepare( $sql2 );

		$stmt2->execute();
		$rstJuveniles = $stmt2->fetchColumn( '0' );

//		total
		$sqlTotal = 'SELECT count(persona.id) as total from persona
		INNER JOIN jugador on persona.id = jugador.persona_id
		INNER JOIN club_jugador on jugador.id = club_jugador.jugador_id		
		WHERE YEAR(DATE_SUB(NOW(), INTERVAL TO_DAYS(persona.fecha_nacimiento) DAY)) > 14
		AND club_jugador.id in (Select max(cj.id) from club_jugador cj where cj.jugador_id = jugador.id)
		AND club_jugador.confirmado_union = TRUE
		AND club_jugador.anio= '. $anio;


		$stmtTotal = $em->getConnection()
		                ->prepare( $sqlTotal );

		$stmtTotal->execute();
		$rstTotal = $stmtTotal->fetchColumn( '0' );

		$porcentaje = round( ( $rstJuveniles / $rstTotal ) * 100, 2 );


		return $porcentaje;
	}

	public function getCountJuvenilesSobreMayoresPorClub( $club, $anio = null ) {

		$em = $this->getEntityManager();

// juveniles
		$sql2 = 'SELECT count(persona.id) as total from persona
		INNER JOIN jugador on persona.id = jugador.persona_id		
		INNER JOIN club_jugador on jugador.id = club_jugador.jugador_id
		WHERE YEAR(DATE_SUB(NOW(), INTERVAL TO_DAYS(persona.fecha_nacimiento) DAY)) BETWEEN 14 and 18
		AND club_jugador.id in (Select max(cj.id) from club_jugador cj where cj.jugador_id = jugador.id)
		AND club_jugador.club_id =' . $club->getId();

		if ( $anio ) {
			$sql2 .= ' AND club_jugador.anio =' . $anio;
		}


		$stmt2 = $em->getConnection()
		            ->prepare( $sql2 );

		$stmt2->execute();
		$rstJuveniles = $stmt2->fetchColumn( '0' );

//		total
		$sqlTotal = 'SELECT count(persona.id) as total from persona
		INNER JOIN jugador on persona.id = jugador.persona_id		
		INNER JOIN club_jugador on jugador.id = club_jugador.jugador_id
		WHERE YEAR(DATE_SUB(NOW(), INTERVAL TO_DAYS(persona.fecha_nacimiento) DAY)) > 14		
		AND club_jugador.id in (Select max(cj.id) from club_jugador cj where cj.jugador_id = jugador.id)
		AND club_jugador.club_id =' . $club->getId();

		if ( $anio ) {
			$sqlTotal .= ' AND club_jugador.anio =' . $anio;
		}


		$stmtTotal = $em->getConnection()
		                ->prepare( $sqlTotal );

		$stmtTotal->execute();
		$rstTotal = $stmtTotal->fetchColumn( '0' );

		$porcentaje = round( ( $rstJuveniles / $rstTotal ) * 100, 2 );


		return $porcentaje;
	}

	public function getCountJugadoresCompetitivosPorClub( $club ) {

		$em = $this->getEntityManager();

		$sqlTotal = 'SELECT count(persona.id) as total from persona
		INNER JOIN jugador on persona.id = jugador.persona_id		
		INNER JOIN club_jugador on jugador.id = club_jugador.jugador_id
		WHERE YEAR(DATE_SUB(NOW(), INTERVAL TO_DAYS(persona.fecha_nacimiento) DAY)) > 14		
		AND club_jugador.id in (Select max(cj.id) from club_jugador cj where cj.jugador_id = jugador.id)
		AND club_jugador.club_id =' . $club->getId();

		$stmtTotal = $em->getConnection()
		                ->prepare( $sqlTotal );

		$stmtTotal->execute();

		return $stmtTotal->fetchColumn( '0' );
	}

	public function getCountJugadoresPorClub( $club, $anio = null ) {

		$em = $this->getEntityManager();

		$sqlTotal = 'SELECT count(persona.id) as total from persona
		INNER JOIN jugador on persona.id = jugador.persona_id		
		INNER JOIN club_jugador on jugador.id = club_jugador.jugador_id				
		AND club_jugador.id in (Select max(cj.id) from club_jugador cj where cj.jugador_id = jugador.id)
		AND club_jugador.confirmado_club = TRUE
		AND club_jugador.club_id =' . $club->getId();

		if ( $anio ) {
			$sqlTotal .= ' AND club_jugador.anio =' . $anio;
		}

		$stmtTotal = $em->getConnection()
		                ->prepare( $sqlTotal );

		$stmtTotal->execute();

		return $stmtTotal->fetchColumn( '0' );
	}

	public function getCountJugadores( $anio = null ) {

		$em = $this->getEntityManager();

		$sqlTotal = 'SELECT count(persona.id) as total from persona
		INNER JOIN jugador on persona.id = jugador.persona_id		
		INNER JOIN club_jugador on jugador.id = club_jugador.jugador_id				
		AND club_jugador.id in (Select max(cj.id) from club_jugador cj where cj.jugador_id = jugador.id)
		AND club_jugador.confirmado_union = TRUE';

		if ( $anio ) {
			$sqlTotal .= ' AND club_jugador.anio =' . $anio;
		}

		$stmtTotal = $em->getConnection()
		                ->prepare( $sqlTotal );

		$stmtTotal->execute();

		return $stmtTotal->fetchColumn( '0' );
	}

	public function getJugadoresCompetitivosPorClubGroupMes( $club ) {

		$em = $this->getEntityManager();

		$sqlCompetitivos = 'SELECT count(persona.id) as total, DATE_FORMAT(club_jugador.fecha_creacion,"%Y-%m") as created_month from persona
		INNER JOIN jugador on persona.id = jugador.persona_id		
		INNER JOIN club_jugador on jugador.id = club_jugador.jugador_id
		WHERE YEAR(DATE_SUB(NOW(), INTERVAL TO_DAYS(persona.fecha_nacimiento) DAY)) > 14		
		AND club_jugador.id in (SELECT max(cj.id) from club_jugador cj where cj.jugador_id = jugador.id)
		AND club_jugador.club_id = ' . $club->getId() . '
		GROUP BY created_month';

		$stmtCompetitivos = $em->getConnection()
		                       ->prepare( $sqlCompetitivos );

		$stmtCompetitivos->execute();

		$retCompetitivos = $stmtCompetitivos->fetchAll();

		$a = [];

		foreach ( $retCompetitivos as $item ) {
			$a[] = [
				'y'              => $item['created_month'],
				'competitivos'   => $item['total'],
				'nocompetitivos' => 0,
			];
		}

		$sqlNoCompetitivos = 'SELECT count(persona.id) as total, DATE_FORMAT(club_jugador.fecha_creacion,"%Y-%m") as created_month from persona
		INNER JOIN jugador on persona.id = jugador.persona_id		
		INNER JOIN club_jugador on jugador.id = club_jugador.jugador_id
		WHERE YEAR(DATE_SUB(NOW(), INTERVAL TO_DAYS(persona.fecha_nacimiento) DAY)) <= 14		
		AND club_jugador.id in (Select max(cj.id) from club_jugador cj where cj.jugador_id = jugador.id)
		AND club_jugador.club_id = ' . $club->getId() . '
		GROUP BY created_month';

		$stmtNoCompetitivos = $em->getConnection()
		                         ->prepare( $sqlNoCompetitivos );

		$stmtNoCompetitivos->execute();

		$retNoCompetitivos = $stmtNoCompetitivos->fetchAll();

		foreach ( $retNoCompetitivos as $item ) {
			$a[] = [
				'y'              => $item['created_month'],
				'nocompetitivos' => $item['total'],
			];
		}

		return json_encode( $a );
	}

	public function getJugadoresCompetitivosGroupMes() {

		$em = $this->getEntityManager();

		$sqlCompetitivos = 'SELECT count(persona.id) as total, DATE_FORMAT(club_jugador.fecha_creacion,"%Y-%m") as created_month from persona
		INNER JOIN jugador on persona.id = jugador.persona_id		
		INNER JOIN club_jugador on jugador.id = club_jugador.jugador_id
		WHERE YEAR(DATE_SUB(NOW(), INTERVAL TO_DAYS(persona.fecha_nacimiento) DAY)) > 14		
		AND club_jugador.id in (Select max(cj.id) from club_jugador cj where cj.jugador_id = jugador.id)
		GROUP BY created_month';

		$stmtCompetitivos = $em->getConnection()
		                       ->prepare( $sqlCompetitivos );

		$stmtCompetitivos->execute();

		$retCompetitivos = $stmtCompetitivos->fetchAll();

		$a = [];

		foreach ( $retCompetitivos as $item ) {
			$a[] = [
				'y'              => $item['created_month'],
				'competitivos'   => $item['total'],
				'nocompetitivos' => 0,
			];
		}

		$sqlNoCompetitivos = 'SELECT count(persona.id) as total, DATE_FORMAT(club_jugador.fecha_creacion,"%Y-%m") as created_month from persona
		INNER JOIN jugador on persona.id = jugador.persona_id		
		INNER JOIN club_jugador on jugador.id = club_jugador.jugador_id
		WHERE YEAR(DATE_SUB(NOW(), INTERVAL TO_DAYS(persona.fecha_nacimiento) DAY)) <= 14		
		AND club_jugador.id in (Select max(cj.id) from club_jugador cj where cj.jugador_id = jugador.id)
		GROUP BY created_month';

		$stmtNoCompetitivos = $em->getConnection()
		                         ->prepare( $sqlNoCompetitivos );

		$stmtNoCompetitivos->execute();

		$retNoCompetitivos = $stmtNoCompetitivos->fetchAll();

		foreach ( $retNoCompetitivos as $item ) {
			$a[] = [
				'y'              => $item['created_month'],
				'nocompetitivos' => $item['total'],
			];
		}

		return json_encode( $a );
	}


}
