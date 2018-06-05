<?php

namespace App\Controller;

use App\Entity\ClubJugador;
use App\Entity\Jugador;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {
	public function indexAction() {

		$em = $this->getDoctrine()->getManager();

		$club = $this->getUser()->getClub();

		if ( $club ) {
			$nuevosFichajes        = count( $em->getRepository( ClubJugador::class )->getCountNuevosFichajes( $club ) );
			$cantidadJugadores     = count( $em->getRepository( ClubJugador::class )->getCountJugadores( $club ) );
			$cantidadCompetitivos  = $em->getRepository( Jugador::class )->getCountJugadoresCompetitivosPorClub($club);
			$juvenilesSobreMayores = $em->getRepository( Jugador::class )->getCountJuvenilesSobreMayoresPorClub($club);


		} else {
			$nuevosFichajes        = $em->getRepository( ClubJugador::class )->getCountAllNuevosFichajes();
			$cantidadJugadores     = $em->getRepository( ClubJugador::class )->getCountAllJugadores();
			$cantidadCompetitivos  = $em->getRepository( ClubJugador::class )->getCountAllJugadoresCompetitivos();
			$juvenilesSobreMayores = $em->getRepository( Jugador::class )->getCountJuvenilesSobreMayores();

		}

		return $this->render( 'app/index.html.twig',
			[
				'nuevosFichajes'        => $nuevosFichajes,
				'cantidadJugadores'     => $cantidadJugadores,
				'cantidadCompetitivos'  => $cantidadCompetitivos,
				'juvenilesSobreMayores' => $juvenilesSobreMayores,
			] );

	}
}
