<?php

namespace App\Controller;

use App\Entity\ClubJugador;
use App\Entity\FichaMedica;
use App\Entity\Jugador;
use App\Entity\Persona;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Jugador controller.
 *
 */
class JugadorController extends Controller {
	/**
	 * Lists all jugador entities.
	 *
	 */
	public function indexAction( Request $request ) {
		$em = $this->getDoctrine()->getManager();

		$club = $this->getUser()->getClub();

		if ( $club ) {
			$jugadors = $em->getRepository( 'App:Jugador' )->getJugadoresByClub( $club );
		} else {
			$jugadors = $em->getRepository( 'App:Jugador' )->getJugadores();
		}

		$paginator = $this->get( 'knp_paginator' );
		$jugadors  = $paginator->paginate(
			$jugadors, /* query NOT result */
			$request->query->getInt( 'page', 1 )/*page number*/,
			10/*limit per page*/
		);

		return $this->render( 'jugador/index.html.twig',
			array(
				'jugadors' => $jugadors,
			) );
	}

	/**
	 * Creates a new jugador entity.
	 *
	 */
	public function newAction( Request $request ) {
//        $jugador = new Jugador();
//        $form = $this->createForm('App\Form\JugadorType', $jugador);
		$persona = new Persona();
		$form    = $this->createForm( 'App\Form\PersonaType', $persona );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->persist( $persona );
			$em->flush();

			return $this->redirectToRoute( 'jugador_show', array( 'id' => $persona->getId() ) );
		}

		return $this->render( 'jugador/new.html.twig',
			array(
				'jugador' => $persona,
//            'jugador' => $jugador,
				'form'    => $form->createView(),
			) );
	}

	/**
	 * Finds and displays a jugador entity.
	 *
	 */
	public function showAction( Jugador $jugador ) {
//		$deleteForm = $this->createDeleteForm( $jugador );

		return $this->render( 'jugador/show.html.twig',
			array(
				'jugador' => $jugador,
//				'delete_form' => $deleteForm->createView(),
			) );
	}

	/**
	 * Displays a form to edit an existing jugador entity.
	 *
	 */
	public function editAction( Request $request, Jugador $jugador ) {

		$persona  = $jugador->getPersona();
		$editForm = $this->createForm( 'App\Form\PersonaType', $persona );
//        $editForm = $this->createForm('App\Form\JugadorType', $jugador);
		$editForm->handleRequest( $request );

		if ( $editForm->isSubmitted() && $editForm->isValid() ) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute( 'jugador_edit', array( 'id' => $jugador->getId() ) );
		}

		return $this->render( 'jugador/edit.html.twig',
			array(
				'jugador'   => $jugador,
				'edit_form' => $editForm->createView(),
			) );
	}

	/**
	 * Deletes a jugador entity.
	 *
	 */
	public function deleteAction( Request $request, Jugador $jugador ) {
		$form = $this->createDeleteForm( $jugador );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->remove( $jugador );
			$em->flush();
		}

		return $this->redirectToRoute( 'jugador_index' );
	}

	/**
	 * Creates a form to delete a jugador entity.
	 *
	 * @param Jugador $jugador The jugador entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm( Jugador $jugador ) {
		return $this->createFormBuilder()
		            ->setAction( $this->generateUrl( 'jugador_delete', array( 'id' => $jugador->getId() ) ) )
		            ->setMethod( 'DELETE' )
		            ->getForm();
	}

	public function precompetitivoPresentacionAction( Request $request ) {

		$em = $this->getDoctrine()->getManager();

		$texto = $em->getRepository( 'App:Texto' )->findOneBySlug( 'evaluacion-pre-competitiva' );

		return $this->render( 'jugador/precompetitivo_presentacion.html.twig',
			array(
				'texto' => $texto
			) );
	}

	public function precompetitivoCategoriaAction( Request $request ) {

		return $this->render( 'jugador/precompetitivo_categoria.html.twig',
			array() );
	}

	public function precompetitivoDatosPersonalesAction( Request $request ) {

		$persona = new Persona();
		$form    = $this->createForm( 'App\Form\PrecompetitivoType', $persona );

		if ( $request->getMethod() == 'POST' ) {
			return $this->render( 'jugador/precompetitivo_datos_personales.html.twig',
				array(
					'form' => $form->createView(),
				) );

		}

		return $this->redirectToRoute( 'jugador_precompetitivo_datos_medicos_presentacion' );

	}

	public function precompetitivoDatosMedicosPresentacionAction( Request $request ) {

		$em = $this->getDoctrine()->getManager();

		$texto = $em->getRepository( 'App:Texto' )->findOneBySlug( 'datos-ficha-medica' );

		return $this->render( 'jugador/precompetitivo_presentacion_datos_medicos.html.twig',
			array(
				'texto' => $texto
			) );
	}

	public function precompetitivoDatosMedicosAction( Request $request ) {

		$form = $this->createForm( 'App\Form\FichaMedicaType' );

		return $this->render( 'jugador/precompetitivo_datos_medicos.html.twig',
			array(
				'form' => $form->createView()
			) );
	}

	public function precompetitivoResumenAction( Request $request ) {


		return $this->render( 'jugador/precompetitivo_resumen.html.twig',
			array() );
	}

	public function precompetitivoConsentimientoAction( Request $request ) {

		$em = $this->getDoctrine()->getManager();

		$texto = $em->getRepository( 'App:Texto' )->findOneBySlug( 'precompetitivo-consentimiento' );

		return $this->render( 'jugador/precompetitivo_consentimiento.html.twig',
			array(
				'texto' => $texto
			) );
	}

	public function precompetitivoOkAction( Request $request, $id ) {

		$em = $this->getDoctrine()->getManager();

		$clubJugador = $em->getRepository( 'App:ClubJugador' )->findOneById( $id );
		$from        = $clubJugador->getJugador()->getPersona()->getFechaNacimiento();
		$to          = new \DateTime( 'today' );
		$edad        = $from->diff( $to )->y;

		return $this->render( 'jugador/precompetitivo_ok.html.twig',
			[
				'clubJugador' => $clubJugador,
				'edad'        => $edad
			] );
	}

	public function preCompetitivoAction( Request $request ) {

		$em = $this->getDoctrine()->getManager();

		// 1
		$textoPresentacion = $em->getRepository( 'App:Texto' )->findOneBySlug( 'evaluacion-pre-competitiva' );

		return $this->render( 'jugador/precompetitivo.html.twig',
			array(
				'texto_presentacion' => $textoPresentacion,

			) );
	}

	public function enviarMailPrecompetitivo( $token, $mail, $persona ) {
		$mailer = $this->get( 'mailer' );

//		$body   = $request->get( 'cuerpo' );
		$asunto = 'URP - Confirmación Precompetitivo';

		$url = $this->get( 'router' )->generate( 'confirmacion_precompetitivo',
			array( 'token' => $token ),
			UrlGeneratorInterface::ABSOLUTE_URL );

		$message = ( new \Swift_Message( $asunto ) )
			->setFrom( $this->container->getParameter( 'mailer_user' ), 'Unión de Rugby del Paraguay ' )
			->setTo( $mail )
			->setBody(
//				$body,
				$this->renderView(
				// app/Resources/views/Emails/registration.html.twig
					'emails/precompetitivo.html.twig',
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

	public function precompetitivoConfirmacionAction( $token ) {

		$em = $this->getDoctrine()->getManager();

		$fichaje = $em->getRepository( 'App:ClubJugador' )->findOneByTokenConfirmacion( $token );

		if ( ! $fichaje ) {
			$mensaje = 'El Token no existe';
		} else {
			if ( $fichaje->getConfirmado() ) {
				$mensaje = 'La evaluación ya está confirmada';
			} else {
				$fichaje->setConfirmado( true );
				$mensaje = 'Solicitud Confirmada con éxito';
				$em->persist( $fichaje );
				$em->flush();
			}
		}

		return $this->render( 'jugador/precompetitivo_mensaje.html.twig',
			array(
				'mensaje'     => $mensaje,
				'clubJugador' => $fichaje
			) );
	}

	public function fichaPrecompetitivaAction( $clubJugadorId ) {
		$em          = $this->getDoctrine()->getManager();
		$clubJugador = $em->getRepository( 'App:ClubJugador' )->findOneById( $clubJugadorId );

		$from = $clubJugador->getJugador()->getPersona()->getFechaNacimiento();
		$to   = new \DateTime( 'today' );
		$edad = $from->diff( $to )->y;

		$title            = 'Evaluación Pre Competitiva';

		$html = $this->renderView( 'jugador/evaluacion_precompetitiva.pdf.twig',
			[
				'clubJugador'        => $clubJugador,
				'title'              => $title,
				'edad'               => $edad
			]
		);

//        return new Response($html);

		return new Response(
			$this->get( 'knp_snappy.pdf' )->getOutputFromHtml( $html,
				array(
					'margin-left'  => "3cm",
					'margin-right' => "3cm",
					'margin-top'   => "3cm",
//                    'margin-bottom' => "1cm"
				)
			)
			, 200, array(
				'Content-Type'        => 'application/pdf',
				'Content-Disposition' => 'inline; filename="' . $title . '.pdf"'
			)
		);

	}
}
