<?php

namespace App\Controller;

use App\Entity\ClubJugador;
use App\Entity\Jugador;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {
	public function indexAction() {

		$em = $this->getDoctrine()->getManager();

		$club = $this->getUser()->getClub();

		$anio = date('Y');

		if ( $club ) {
			$nuevosFichajes        = count( $em->getRepository( ClubJugador::class )->getCountNuevosFichajes( $club ) );
			$cantidadJugadores     = $em->getRepository( Jugador::class )->getCountJugadoresPorClub( $club, $anio );
			$cantidadCompetitivos  = $em->getRepository( ClubJugador::class )->getCountAllJugadoresCompetitivosPorClub($club);
			$juvenilesSobreMayores = $em->getRepository( Jugador::class )->getCountJuvenilesSobreMayoresPorClub( $club, $anio );
			$jsonCompetitivos = $em->getRepository( Jugador::class )->getJugadoresCompetitivosPorClubGroupMes( $club );


		} else {
			$nuevosFichajes        = $em->getRepository( ClubJugador::class )->getCountAllNuevosFichajes();
			$cantidadJugadores     = $em->getRepository( Jugador::class )->getCountJugadores($anio);
			$cantidadCompetitivos  = $em->getRepository( ClubJugador::class )->getCountAllJugadoresCompetitivos();
			$juvenilesSobreMayores = $em->getRepository( Jugador::class )->getCountJuvenilesSobreMayores($anio);
			$jsonCompetitivos = $em->getRepository( Jugador::class )->getJugadoresCompetitivosGroupMes();
		}

		return $this->render( 'app/index.html.twig',
			[
				'nuevosFichajes'        => $nuevosFichajes,
				'cantidadJugadores'     => $cantidadJugadores,
				'cantidadCompetitivos'  => $cantidadCompetitivos,
				'juvenilesSobreMayores' => $juvenilesSobreMayores,
				'jsonCompetitivos' => $jsonCompetitivos,
			] );

	}

//	public function consultaJugadores( Request $request ) {
//
//	}
}
