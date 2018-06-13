<?php

namespace App\Controller;

use App\Entity\ClubJugador;
use App\Form\Filter\BuscarJugadoresFilterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


/**
 * Clubjugador controller.
 *
 */
class ClubJugadorController extends Controller {
	/**
	 * Lists all clubJugador entities.
	 *
	 */
	public function indexAction( Request $request ) {
		$em = $this->getDoctrine()->getManager();

		$club = $this->getUser()->getClub();

		$filterType = $this->createForm( BuscarJugadoresFilterType::class,
			null,
			[
				'method' => 'GET'
			] );

		if ( $club ) {
			$filterType->handleRequest( $request );
			if ( $filterType->isSubmitted() && $filterType->get( 'buscar' )->isClicked() ) {
				$clubJugadors = $em->getRepository( ClubJugador::class )->getQbBuscarRegistroJugadores( $filterType->getData(),
					$club );
			} else {
				$clubJugadors = $em->getRepository( ClubJugador::class )->getQbRegistroJugadores( $club );
			}
		} elseif ( $this->getUser()->hasRole( 'ROLE_UNION' ) ) {

			$filterType->handleRequest( $request );

			if ( $filterType->isSubmitted() && $filterType->get( 'buscar' )->isClicked() ) {
				$clubJugadors = $em->getRepository( ClubJugador::class )->getQbBuscarByUnion( $filterType->getData() );
			} else {
				$clubJugadors = $em->getRepository( ClubJugador::class )->getQbByUnion();
			}

		} else {
			$clubJugadors = [];
		}

		$paginator    = $this->get( 'knp_paginator' );
		$clubJugadors = $paginator->paginate(
			$clubJugadors, /* query NOT result */
			$request->query->getInt( 'page', 1 )/*page number*/,
			10/*limit per page*/
		);

		return $this->render( 'clubjugador/index.html.twig',
			array(
				'clubJugadors' => $clubJugadors,
				'filter_type'  => $filterType->createView()
			) );
	}

	/**
	 * Finds and displays a clubJugador entity.
	 *
	 */
	public function showAction( ClubJugador $clubJugador ) {

		return $this->render( 'clubjugador/show.html.twig',
			array(
				'clubJugador' => $clubJugador,
			) );
	}

	public function confirmarAction( Request $request, $id ) {
		$em = $this->getDoctrine()->getManager();

		$confirmarUnion = $this->getUser()->hasRole( 'ROLE_UNION' );
		$confirmarClub  = $this->getUser()->hasRole( 'ROLE_CLUB' );

		$jugador = $em->getRepository( 'App:ClubJugador' )->find( $id );
		$form    = $this->createForm( 'App\Form\ConfirmarType',
			$jugador,
			[
				'confirmarUnion' => $confirmarUnion,
				'confirmarClub'  => $confirmarClub
			] );

		$fichaMedica = $em->getRepository( 'App:FichaMedica' )->findOneByClubJugador( $jugador );

		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {

			if ( $confirmarClub ) {

				$fichaMedica->setDoctor( $request->get( 'doctor' ) );
				$fichaMedica->setMatricula( $request->get( 'matricula' ) );
				$em->persist( $fichaMedica );

				$jugador->setFechaConfirmacionClub( new \DateTime( 'now' ) );
			}

			if ( $confirmarUnion ) {
				$jugador->setFechaConfirmacionUnion( new \DateTime( 'now' ) );
			}


			$em->persist( $jugador );
			$em->flush();

			$this->get( 'session' )->getFlashBag()->add( 'success', 'El Fichaje se confirmó con éxito!' );

			return $this->redirectToRoute( 'clubjugador_index' );
		}

		return $this->render( 'clubjugador/confirmar.html.twig',
			[
				'form'        => $form->createView(),
				'jugador'     => $jugador,
				'fichaMedica' => $fichaMedica,

			] );
	}

	public function rechazarAction( Request $request, $id ) {

		$em = $this->getDoctrine()->getManager();

		$jugador = $em->getRepository( 'App:ClubJugador' )->find( $id );

		$persona = $jugador->getJugador()->getPersona();

		$em->remove( $jugador );
		$responsable = $em->getRepository( 'App:ResponsableJugador' )->findOneByJugador( $jugador->getJugador() );
		if ( $responsable ) {
			$em->remove( $responsable );
		}
		$em->flush();

		$this->enviarMailRechazo( $persona->getContacto()->getMail(), $persona );

		$this->get( 'session' )->getFlashBag()->add( 'warning', 'El Fichaje fue rechazado!' );


		return $this->redirectToRoute( 'clubjugador_index' );

	}


	public function enviarMailRechazo( $mail, $persona ) {
		$mailer = $this->get( 'mailer' );


		$asunto = getenv( 'APP_SITE_NAME' ) . ' - Precompetitivo Rechazado';

		$url = $this->get( 'router' )->generate( 'jugador_registro',
			array(),
			UrlGeneratorInterface::ABSOLUTE_URL );

		$message = ( new \Swift_Message( $asunto ) )
			->setFrom( getenv( 'MAILER_USER' ), getenv( 'APP_UNION_NAME' ) )
			->setTo( $mail )
			->setBody(
				$this->renderView(
					'emails/rechazo.html.twig',
					[
						'nombre' => $persona->getNombre() . ' ' . $persona->getApellido(),
						'url'    => $url
					]
				),
				'text/html'
			);

		$mailer->send( $message );
	}

	public function reenviarMailConfirmacion( Request $request, ClubJugador $id ) {
		$mailer = $this->get( 'mailer' );

		$clubJugador = $id;

		$persona = $clubJugador->getJugador()->getPersona();
		$token   = $clubJugador->getTokenConfirmacion();
		$mail    = $clubJugador->getJugador()->getPersona()->getContacto()->getMail();

		$asunto = getenv( 'APP_SITE_NAME' ) . ' - Confirmación Precompetitivo';

		$url = $this->get( 'router' )->generate( 'confirmacion_precompetitivo',
			array( 'token' => $token ),
			UrlGeneratorInterface::ABSOLUTE_URL );

		$message = ( new \Swift_Message( $asunto ) )
			->setFrom( getenv( 'MAILER_USER' ), getenv( 'APP_UNION_NAME' ) )
			->setTo( $mail )
			->setBody(
				$this->renderView(
					'emails/precompetitivo.html.twig',
					[
						'nombre' => $persona->getNombre() . ' ' . $persona->getApellido(),
						'url'    => $url
					]
				),
				'text/html'
			);

		$mailer->send( $message );

		$this->get( 'session' )->getFlashBag()->add( 'success', 'Se reenvió el mail a: ' . $mail );

		return $this->redirectToRoute( 'clubjugador_index' );
	}
}
