<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ClubJugador;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


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

		if ( $club ) {
			$clubJugadors = $em->getRepository( 'AppBundle:ClubJugador' )->getQbByClub( $club );
		} elseif ( $this->getUser()->hasRole( 'ROLE_ADMIN' ) ) {
			$clubJugadors = $em->getRepository( 'AppBundle:ClubJugador' )->getQbByUnion();
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

		$jugador = $em->getRepository( 'AppBundle:ClubJugador' )->find( $id );
		$form    = $this->createForm( 'AppBundle\Form\ConfirmarType',
			$jugador,
			[
				'confirmarUnion' => $confirmarUnion,
				'confirmarClub'  => $confirmarClub
			] );

		$fichaMedica = $em->getRepository( 'AppBundle:FichaMedica' )->findOneByClubJugador( $jugador );

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

		return $this->render( ':clubjugador:confirmar.html.twig',
			[
				'form'        => $form->createView(),
				'jugador'     => $jugador,
				'fichaMedica' => $fichaMedica,

			] );
	}

	public function rechazarAction( Request $request, $id ) {

		$em = $this->getDoctrine()->getManager();

		$jugador = $em->getRepository( 'AppBundle:ClubJugador' )->find( $id );

		$persona = $jugador->getJugador()->getPersona();

		$em->remove( $jugador );
		$responsable = $em->getRepository( 'AppBundle:ResponsableJugador' )->findOneByJugador( $jugador->getJugador() );
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


		$asunto = $this->getParameter( 'site_name' ) . ' - Precompetitivo Rechazado';

		$url = $this->get( 'router' )->generate( 'jugador_precompetitivo',
			array(),
			UrlGeneratorInterface::ABSOLUTE_URL );

		$message = ( new \Swift_Message( $asunto ) )
			->setFrom( $this->container->getParameter( 'mailer_user' ), $this->getParameter( 'union_name' ) )
			->setTo( $mail )
			->setBody(
//				$body,
				$this->renderView(
				// app/Resources/views/Emails/registration.html.twig
					'emails/rechazo.html.twig',
					[
						'nombre' => $persona->getNombre() . ' ' . $persona->getApellido(),
						'url'    => $url
					]
				),
				'text/html'
			)/*
                 * If you also want to include a plaintext version of the message
                ->addPart(
                    $this->renderView(
                        'Emails/registration.txt.twig',
                        array('name' => $name)
                    ),
                    'text/plain'
                )
                */
		;

		$mailer->send( $message );
//		$this->get( 'session' )->getFlashBag()->add( 'info', 'El mail se envió con éxito!' );
	}
}
