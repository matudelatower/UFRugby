<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Jugador;
use AppBundle\Entity\Persona;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Jugador controller.
 *
 */
class JugadorController extends Controller {
	/**
	 * Lists all jugador entities.
	 *
	 */
	public function indexAction() {
		$em = $this->getDoctrine()->getManager();

		$jugadors = $em->getRepository( 'AppBundle:Jugador' )->findAll();

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

	public function precompetitivoAction() {

		$persona = new Persona();
		$form    = $this->createForm( 'AppBundle\Form\PrecompetitivoType', $persona );

		return $this->render( 'jugador/precompetitivo.html.twig',
			array(
				'form' => $form->createView()
			) );
	}
}
