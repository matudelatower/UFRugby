<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {
	public function indexAction() {

		$em = $this->getDoctrine()->getManager();

		$club = $this->getUser()->getClub();

		if ( $club ) {
			$nuevosFichajes    = count( $em->getRepository( 'AppBundle:ClubJugador' )->getCountNuevosFichajes( $club ) );
			$cantidadJugadores = $em->getRepository( 'AppBundle:ClubJugador' )->getCountJugadores( $club );
			$incidencias       = 0;
			$estadisticas      = 0;


		} else {
			$nuevosFichajes    = $em->getRepository( 'AppBundle:ClubJugador' )->getCountAllNuevosFichajes();
			$cantidadJugadores = $em->getRepository( 'AppBundle:ClubJugador' )->getCountAllJugadores();
			$incidencias       = 0;
			$estadisticas      = 0;

		}

		return $this->render( 'AppBundle:Default:index.html.twig',
			[
				'nuevosFichajes'    => $nuevosFichajes,
				'cantidadJugadores' => $cantidadJugadores,
				'incidencias'       => $incidencias,
				'estadisticas'      => $estadisticas,
			] );

	}
}
