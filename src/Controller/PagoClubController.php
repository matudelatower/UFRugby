<?php

namespace App\Controller;

use App\Entity\PagoClub;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;use Knp\Component\Pager\PaginatorInterface;

/**
 * Pagoclub controller.
 *
 */
class PagoClubController extends AbstractController {
	/**
	 * Lists all pagoClub entities.
	 *
	 */
	public function indexAction( Request $request, PaginatorInterface $paginator ) {
		$em = $this->getDoctrine()->getManager();

		$pagoClubs = $em->getRepository( PagoClub::class )->findQbAll();

		
		$pagoClubs = $paginator->paginate(
			$pagoClubs, /* query NOT result */
			$request->query->getInt( 'page', 1 )/*page number*/,
			10/*limit per page*/
		);

		return $this->render( 'pagoclub/index.html.twig',
			array(
				'pagoClubs' => $pagoClubs,
			) );
	}

	/**
	 * Creates a new pagoClub entity.
	 *
	 */
	public function newAction( Request $request ) {
		$pagoClub = new Pagoclub();
		$form     = $this->createForm( 'App\Form\PagoClubType', $pagoClub );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->persist( $pagoClub );
			$em->flush();

			$this->get( 'session' )->getFlashBag()->add( 'success', 'Pago registrado correctamente' );

			return $this->redirectToRoute( 'pagoclub_show', array( 'id' => $pagoClub->getId() ) );
		}

		return $this->render( 'pagoclub/new.html.twig',
			array(
				'pagoClub' => $pagoClub,
				'form'     => $form->createView(),
			) );
	}

	/**
	 * Finds and displays a pagoClub entity.
	 *
	 */
	public function showAction( PagoClub $pagoClub ) {
		$deleteForm = $this->createDeleteForm( $pagoClub );

		return $this->render( 'pagoclub/show.html.twig',
			array(
				'pagoClub'    => $pagoClub,
				'delete_form' => $deleteForm->createView(),
			) );
	}

	/**
	 * Displays a form to edit an existing pagoClub entity.
	 *
	 */
	public function editAction( Request $request, PagoClub $pagoClub ) {
		$deleteForm = $this->createDeleteForm( $pagoClub );
		$editForm   = $this->createForm( 'App\Form\PagoClubType', $pagoClub );
		$editForm->handleRequest( $request );

		if ( $editForm->isSubmitted() && $editForm->isValid() ) {
			$this->getDoctrine()->getManager()->flush();

			$this->get( 'session' )->getFlashBag()->add(
				'success',
				'El Pago se modificó correctamente'
			);

			return $this->redirectToRoute( 'pagoclub_edit', array( 'id' => $pagoClub->getId() ) );
		}

		return $this->render( 'pagoclub/edit.html.twig',
			array(
				'pagoClub'    => $pagoClub,
				'edit_form'   => $editForm->createView(),
				'delete_form' => $deleteForm->createView(),
			) );
	}

	/**
	 * Deletes a pagoClub entity.
	 *
	 */
	public function deleteAction( Request $request, PagoClub $pagoClub ) {
		$form = $this->createDeleteForm( $pagoClub );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->remove( $pagoClub );
			$em->flush();
		}

		return $this->redirectToRoute( 'pagoclub_index' );
	}

	/**
	 * Creates a form to delete a pagoClub entity.
	 *
	 * @param PagoClub $pagoClub The pagoClub entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm( PagoClub $pagoClub ) {
		return $this->createFormBuilder()
		            ->setAction( $this->generateUrl( 'pagoclub_delete', array( 'id' => $pagoClub->getId() ) ) )
		            ->setMethod( 'DELETE' )
		            ->getForm();
	}
}
