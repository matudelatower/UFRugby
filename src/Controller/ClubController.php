<?php

namespace App\Controller;

use App\Entity\Club;
use App\Entity\Jugador;
use App\Form\Filter\ClubFilterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Club controller.
 *
 */
class ClubController extends Controller {
	/**
	 * Lists all club entities.
	 *
	 */
	public function indexAction( Request $request ) {
		$em = $this->getDoctrine()->getManager();

		$filterType = $this->createForm( ClubFilterType::class,
			null,
			[
				'method' => 'GET'
			] );

		$filterType->handleRequest( $request );

		if ( $filterType->get( 'buscar' )->isClicked() ) {
			$clubs = $em->getRepository( Club::class )->findQbBuscar( $filterType->getData() );
		} else {
			$clubs = $em->getRepository( Club::class )->findQbAll();
		}

		$paginator = $this->get( 'knp_paginator' );
		$clubs     = $paginator->paginate(
			$clubs, /* query NOT result */
			$request->query->getInt( 'page', 1 )/*page number*/,
			10/*limit per page*/
		);

		return $this->render( 'club/index.html.twig',
			array(
				'clubs'       => $clubs,
				'filter_type' => $filterType->createView()
			) );
	}

	/**
	 * Creates a new club entity.
	 *
	 */
	public function newAction( Request $request ) {
		$club = new Club();
		$form = $this->createForm( 'App\Form\ClubType', $club );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->persist( $club );
			$em->flush();

			$this->get( 'session' )->getFlashBag()->add(
				'success',
				'Club creado correctamente!'
			);

			return $this->redirectToRoute( 'club_show', array( 'id' => $club->getId() ) );
		}

		return $this->render( 'club/new.html.twig',
			array(
				'club' => $club,
				'form' => $form->createView(),
			) );
	}

	/**
	 * Finds and displays a club entity.
	 *
	 */
	public function showAction( Club $club ) {

		$em = $this->getDoctrine()->getManager();

		$jugadors = $em->getRepository( Jugador::class )->getJugadoresByClub( $club );

		$jugadores = $jugadors->getQuery()->getResult();

		return $this->render( 'club/show.html.twig',
			array(
				'club'      => $club,
				'jugadores' => $jugadores
//				'delete_form' => $deleteForm->createView(),
			) );
	}

	/**
	 * Displays a form to edit an existing club entity.
	 *
	 */
	public function editAction( Request $request, Club $club ) {
		$deleteForm = $this->createDeleteForm( $club );
		$editForm   = $this->createForm( 'App\Form\ClubType', $club );
		$editForm->handleRequest( $request );

		if ( $editForm->isSubmitted() && $editForm->isValid() ) {
			$this->getDoctrine()->getManager()->flush();

			$this->get( 'session' )->getFlashBag()->add(
				'success',
				'Club modificado correctamente!'
			);


			return $this->redirectToRoute( 'club_edit', array( 'id' => $club->getId() ) );
		}

		return $this->render( 'club/edit.html.twig',
			array(
				'club'        => $club,
				'edit_form'   => $editForm->createView(),
				'delete_form' => $deleteForm->createView(),
			) );
	}

	/**
	 * Deletes a club entity.
	 *
	 */
	public function deleteAction( Request $request, Club $club ) {
		$form = $this->createDeleteForm( $club );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->remove( $club );
			$em->flush();
		}

		return $this->redirectToRoute( 'club_index' );
	}

	/**
	 * Creates a form to delete a club entity.
	 *
	 * @param Club $club The club entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm( Club $club ) {
		return $this->createFormBuilder()
		            ->setAction( $this->generateUrl( 'club_delete', array( 'id' => $club->getId() ) ) )
		            ->setMethod( 'DELETE' )
		            ->getForm();
	}
}
