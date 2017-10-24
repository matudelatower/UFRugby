<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ClubJugador;
use AppBundle\Entity\FichaMedica;
use AppBundle\Entity\Jugador;
use AppBundle\Entity\Persona;
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

		$jugadors = $em->getRepository( 'AppBundle:Jugador' )->getQbAll();


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
//        $form = $this->createForm('AppBundle\Form\JugadorType', $jugador);
		$persona = new Persona();
		$form    = $this->createForm( 'AppBundle\Form\PersonaType', $persona );
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
		$deleteForm = $this->createDeleteForm( $jugador );

		return $this->render( 'jugador/show.html.twig',
			array(
				'jugador'     => $jugador,
				'delete_form' => $deleteForm->createView(),
			) );
	}

	/**
	 * Displays a form to edit an existing jugador entity.
	 *
	 */
	public function editAction( Request $request, Jugador $jugador ) {

		$persona  = $jugador->getPersona();
		$editForm = $this->createForm( 'AppBundle\Form\PersonaType', $persona );
//        $editForm = $this->createForm('AppBundle\Form\JugadorType', $jugador);
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

		$texto = $em->getRepository( 'AppBundle:Texto' )->findOneBySlug( 'evaluacion-pre-competitiva' );

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
		$form    = $this->createForm( 'AppBundle\Form\PrecompetitivoType', $persona );

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

		$texto = $em->getRepository( 'AppBundle:Texto' )->findOneBySlug( 'datos-ficha-medica' );

		return $this->render( 'jugador/precompetitivo_presentacion_datos_medicos.html.twig',
			array(
				'texto' => $texto
			) );
	}

	public function precompetitivoDatosMedicosAction( Request $request ) {

		$form = $this->createForm( 'AppBundle\Form\FichaMedicaType' );

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

		$texto = $em->getRepository( 'AppBundle:Texto' )->findOneBySlug( 'precompetitivo-consentimiento' );

		return $this->render( 'jugador/precompetitivo_consentimiento.html.twig',
			array(
				'texto' => $texto
			) );
	}

	public function precompetitivoOkAction( Request $request ) {


		return $this->render( 'jugador/precompetitivo_ok.html.twig',
			array() );
	}

	public function preCompetitivoAction( Request $request ) {

		$em = $this->getDoctrine()->getManager();

		// 1
		$textoPresentacion = $em->getRepository( 'AppBundle:Texto' )->findOneBySlug( 'evaluacion-pre-competitiva' );

		// 2
		$persona     = new Persona();
		$jugador     = new Jugador();
		$clubJugador = new ClubJugador();
		$jugador->addClubJugador( $clubJugador );
		$persona->setJugador( $jugador );
		$jugador->setPersona( $persona );

		$form = $this->createForm( 'AppBundle\Form\PrecompetitivoType', $persona );

		// 3
		$textoFichaMedica = $em->getRepository( 'AppBundle:Texto' )->findOneBySlug( 'datos-ficha-medica' );

		// 4
		$fichaMedica     = new FichaMedica();
		$formFichaMedica = $this->createForm( 'AppBundle\Form\FichaMedicaType', $fichaMedica );

		// 5
		$textoConsentimiento = $em->getRepository( 'AppBundle:Texto' )->findOneBySlug( 'precompetitivo-consentimiento' );

		if ( $request->getMethod() == 'POST' ) {
			$form->handleRequest( $request );

			$form1Valid = $form2Valid = false;

			if ( $form->isValid() ) {
				$em->persist( $persona );
				$form1Valid = true;
			}
			$formFichaMedica->handleRequest( $request );
			if ( $formFichaMedica->isValid() ) {
				$fichaMedica->setClubJugador( $clubJugador );
				$em->persist( $fichaMedica );
				$form2Valid = true;
			}

			if ( $form1Valid && $form2Valid ) {
				$token = md5( uniqid( 'urp_' ) );

				$clubJugador->setJugador( $persona->getJugador() );
				$clubJugador->setTokenConfirmacion( $token );
				$clubJugador->setAnio( date( "Y" ) );

				$em->flush();
				$this->enviarMailPrecompetitivo( $token, $persona->getContacto()->getMail(), $persona );

				return $this->render( ':jugador:precompetitivo_ok.html.twig' );
			}
		}

		return $this->render( 'jugador/precompetitivo2.html.twig',
			array(
				'texto_presentacion'   => $textoPresentacion,
				'form'                 => $form->createView(),
				'texto_ficha_medica'   => $textoFichaMedica,
				'formFichaMedica'      => $formFichaMedica->createView(),
				'texto_consentimiento' => $textoConsentimiento,

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

		$fichaje = $em->getRepository( 'AppBundle:ClubJugador' )->findOneByTokenConfirmacion( $token );

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

		return $this->render( ':jugador:precompetitivo_mensaje.html.twig',
			array(
				'mensaje'     => $mensaje,
				'clubJugador' => $fichaje
			) );
	}

	public function fichaPrecompetitivaAction( $clubJugadorId ) {
		$em               = $this->getDoctrine()->getManager();
		$clubJugador      = $em->getRepository( 'AppBundle:ClubJugador' )->findOneById( $clubJugadorId );
		$title            = 'Evaluación PreCompetitiva';
		$textoFichaMedica = $em->getRepository( 'AppBundle:Texto' )->findOneBySlug( 'datos-ficha-medica' );

		$html = $this->renderView( ':jugador:evaluacion_precompetitiva.pdf.twig',
			[
				'clubJugador'      => $clubJugador,
				'title'            => $title,
				'texto_ficha_medica' => $textoFichaMedica
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
