<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {
	public function indexAction() {

		$em = $this->getDoctrine()->getManager();

		$club = $this->getUser()->getClub();

		if ( $club ) {
			$nuevosFichajes    = $em->getRepository( 'AppBundle:ClubJugador' )->getCountNuevosFichajes( $club );
			$cantidadJugadores = $em->getRepository( 'AppBundle:ClubJugador' )->getCountJugadores( $club );
			$incidencias       = [];
			$estadisticas      = [];


		} else {
			$nuevosFichajes    = [];
			$cantidadJugadores = [];
			$incidencias       = [];
			$estadisticas      = [];
			
		}

		return $this->render( 'AppBundle:Default:index.html.twig',
			[
				'nuevosFichajes'    => count( $nuevosFichajes ),
				'cantidadJugadores' => count( $cantidadJugadores ),
				'incidencias'       => count( $incidencias ),
				'estadisticas'      => count( $estadisticas ),
			] );

	}
}
