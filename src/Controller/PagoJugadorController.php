<?php

namespace App\Controller;

use App\Entity\PagoJugador;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Pagojugador controller.
 *
 */
class PagoJugadorController extends Controller {
	/**
	 * Lists all pagoJugador entities.
	 *
	 */
	public function indexAction( Request $request ) {
		$em = $this->getDoctrine()->getManager();

		$club = $this->getUser()->getClub();

		$pagoJugadors = $em->getRepository( PagoJugador::class )->findQbByClub( $club );


		$paginator    = $this->get( 'knp_paginator' );
		$pagoJugadors = $paginator->paginate(
			$pagoJugadors, /* query NOT result */
			$request->query->getInt( 'page', 1 )/*page number*/,
			10/*limit per page*/
		);

//		TODO opcion de pago anual

		return $this->render( 'pagojugador/index.html.twig',
			array(
				'pagoJugadors' => $pagoJugadors,
			) );
	}

	/**
	 * Creates a new pagoJugador entity.
	 *
	 */
	public function newAction( Request $request ) {
		$pagoJugador = new Pagojugador();

		$club = $this->getUser()->getClub();
		$pagoJugador->setClub( $club );

		$form = $this->createForm( 'App\Form\PagoJugadorType',
			$pagoJugador,
			[
				'club' => $club
			] );

		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();

			$em->persist( $pagoJugador );
			$em->flush();

			$this->get( 'session' )->getFlashBag()->add(
				'success',
				'El Pago se creó correctamente'
			);

			return $this->redirectToRoute( 'pagojugador_show', array( 'id' => $pagoJugador->getId() ) );
		}

		return $this->render( 'pagojugador/new.html.twig',
			array(
				'pagoJugador' => $pagoJugador,
				'form'        => $form->createView(),
			) );
	}

	/**
	 * Finds and displays a pagoJugador entity.
	 *
	 */
	public function showAction( PagoJugador $pagoJugador ) {
		$deleteForm = $this->createDeleteForm( $pagoJugador );

		return $this->render( 'pagojugador/show.html.twig',
			array(
				'pagoJugador' => $pagoJugador,
				'delete_form' => $deleteForm->createView(),
			) );
	}

	/**
	 * Displays a form to edit an existing pagoJugador entity.
	 *
	 */
	public function editAction( Request $request, PagoJugador $pagoJugador ) {
		$deleteForm = $this->createDeleteForm( $pagoJugador );
		$editForm   = $this->createForm( 'App\Form\PagoJugadorType', $pagoJugador );
		$editForm->handleRequest( $request );

		if ( $editForm->isSubmitted() && $editForm->isValid() ) {
			$this->getDoctrine()->getManager()->flush();

			$this->get( 'session' )->getFlashBag()->add(
				'success',
				'El Pago se modificó correctamente'
			);

			return $this->redirectToRoute( 'pagojugador_edit', array( 'id' => $pagoJugador->getId() ) );
		}

		return $this->render( 'pagojugador/edit.html.twig',
			array(
				'pagoJugador' => $pagoJugador,
				'edit_form'   => $editForm->createView(),
				'delete_form' => $deleteForm->createView(),
			) );
	}

	/**
	 * Deletes a pagoJugador entity.
	 *
	 */
	public function deleteAction( Request $request, PagoJugador $pagoJugador ) {
		$form = $this->createDeleteForm( $pagoJugador );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->remove( $pagoJugador );
			$em->flush();
		}

		return $this->redirectToRoute( 'pagojugador_index' );
	}

	/**
	 * Creates a form to delete a pagoJugador entity.
	 *
	 * @param PagoJugador $pagoJugador The pagoJugador entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm( PagoJugador $pagoJugador ) {
		return $this->createFormBuilder()
		            ->setAction( $this->generateUrl( 'pagojugador_delete', array( 'id' => $pagoJugador->getId() ) ) )
		            ->setMethod( 'DELETE' )
		            ->getForm();
	}
}
