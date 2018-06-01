<?php

namespace App\Controller;

use App\Entity\InscripcionReferee;
use App\Entity\Referee;
use App\Form\Filter\RefereeFilterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RefereeController extends Controller {

	public function index( Request $request ) {

		$em = $this->getDoctrine()->getManager();

		$filterType = $this->createForm( RefereeFilterType::class,
			null,
			[
				'method' => 'GET'
			] );

		$filterType->handleRequest( $request );

		if ( $filterType->get( 'buscar' )->isClicked() ) {
			$referees = $em->getRepository( Referee::class )->findQbBuscar( $filterType->getData() );
		} else {
			$referees = $em->getRepository( Referee::class )->findQbAll();
		}

		$paginator = $this->get( 'knp_paginator' );
		$referees  = $paginator->paginate(
			$referees, /* query NOT result */
			$request->query->getInt( 'page', 1 )/*page number*/,
			10/*limit per page*/
		);

		return $this->render( 'referee/index.html.twig',
			[
				'referees'    => $referees,
				'filter_type' => $filterType->createView()
			] );
	}

	public function show( Referee $id ) {
		return $this->render( 'referee/show.html.twig',
			array(
				'referee' => $id,
			) );
	}

	public function inscripcionOk( Request $request, $id ) {
		$em = $this->getDoctrine()->getManager();

		$referee = $em->getRepository( Referee::class )->find( $id );

		return $this->render( 'referee/inscripcion_ok.html.twig',
			[
				'referee' => $referee
			] );
	}

	public function confirmacionInscripcion( $token ) {
		$em = $this->getDoctrine()->getManager();

		$inscripcionReferee = $em->getRepository( InscripcionReferee::class )->findOneByTokenConfirmacion( $token );

		if ( ! $inscripcionReferee ) {
			$mensaje = 'El Token no existe';
		} else {
			if ( $inscripcionReferee->getConfirmado() ) {
				$mensaje = 'La Solicitud ya está confirmada';
			} else {
				$inscripcionReferee->setConfirmado( true );
				$mensaje = 'Solicitud Confirmada con éxito';

				$em->flush();
			}
		}

		return $this->render( 'referee/inscripcion_mensaje.html.twig',
			array(
				'mensaje' => $mensaje
			) );
	}
}
