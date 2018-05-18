<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {
	public function indexAction() {

		$em = $this->getDoctrine()->getManager();

		$club = $this->getUser()->getClub();

		if ( $club ) {
			$nuevosFichajes    = count( $em->getRepository( 'App:ClubJugador' )->getCountNuevosFichajes( $club ) );
			$cantidadJugadores = count($em->getRepository( 'App:ClubJugador' )->getCountJugadores( $club ));
			$incidencias       = 0;
			$estadisticas      = 0;


		} else {
			$nuevosFichajes    = $em->getRepository( 'App:ClubJugador' )->getCountAllNuevosFichajes();
			$cantidadJugadores = $em->getRepository( 'App:ClubJugador' )->getCountAllJugadores();
			$incidencias       = 0;
			$estadisticas      = 0;

		}

		return $this->render( 'app/index.html.twig',
			[
				'nuevosFichajes'    => $nuevosFichajes,
				'cantidadJugadores' => $cantidadJugadores,
				'incidencias'       => $incidencias,
				'estadisticas'      => $estadisticas,
			] );

	}
}
