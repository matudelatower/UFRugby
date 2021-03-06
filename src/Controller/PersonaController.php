<?php

namespace App\Controller;

use App\Entity\Persona;
use App\Form\PersonaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Persona controller.
 *
 * @Route("/persona")
 */
class PersonaController extends AbstractController {
	/**
	 * Lists all persona entities.
	 *
	 */
	public function indexAction() {
		$em = $this->getDoctrine()->getManager();

		$personas = $em->getRepository( 'App:Persona' )->findAll();

		return $this->render( 'persona/index.html.twig',
			array(
				'personas' => $personas,
			) );
	}

	/**
	 * Creates a new persona entity.
	 *
	 */
	public function newAction( Request $request ) {
		$persona = new Persona();
		$form    = $this->createForm( 'App\Form\PersonaType', $persona );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->persist( $persona );
			$em->flush();

			return $this->redirectToRoute( 'persona_show', array( 'id' => $persona->getId() ) );
		}

		return $this->render( 'persona/new.html.twig',
			array(
				'persona' => $persona,
				'form'    => $form->createView(),
			) );
	}

	/**
	 * Finds and displays a persona entity.
	 *
	 */
	public function showAction( Persona $persona ) {
		$deleteForm = $this->createDeleteForm( $persona );

		return $this->render( 'persona/show.html.twig',
			array(
				'persona'     => $persona,
				'delete_form' => $deleteForm->createView(),
			) );
	}

	/**
	 * Displays a form to edit an existing persona entity.
	 *
	 */
	public function editAction( Request $request, Persona $persona ) {
		$referer = null;
		if ( $request->get( 'referer' ) ) {
			$referer = $request->get( 'referer' );
		}
		if ( $request->request->get( 'referer' ) ) {
			$referer = $request->request->get( 'referer' );
		}

		$editForm = $this->createForm( PersonaType::class, $persona );
		$editForm->handleRequest( $request );

		if ( $editForm->isSubmitted() && $editForm->isValid() ) {
			$this->getDoctrine()->getManager()->flush();

			$this->get( 'session' )->getFlashBag()->add( 'success', 'Persona modificada Correctamente!' );

			return $this->redirectToRoute( 'persona_edit',
				[
					'id'      => $persona->getId(),
					'referer' => $referer
				] );
		}

		return $this->render( 'persona/edit.html.twig',
			array(
				'persona'   => $persona,
				'edit_form' => $editForm->createView(),
				'referer'   => $referer
			) );
	}

	/**
	 * Deletes a persona entity.
	 *
	 */
	public function deleteAction( Request $request, Persona $persona ) {
		$form = $this->createDeleteForm( $persona );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->remove( $persona );
			$em->flush();
		}

		return $this->redirectToRoute( 'persona_index' );
	}

	/**
	 * Creates a form to delete a persona entity.
	 *
	 * @param Persona $persona The persona entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm( Persona $persona ) {
		return $this->createFormBuilder()
		            ->setAction( $this->generateUrl( 'persona_delete', array( 'id' => $persona->getId() ) ) )
		            ->setMethod( 'DELETE' )
		            ->getForm();
	}

	/**
	 * @Route("/persona-ver-identificacion/{persona}", name="persona_ver_identificacion", methods={"GET"})
	 */
	public function verIdentificacion( Request $request, Persona $persona ) {

		$html         = $this->renderView( 'persona/ver_identificacion.html.twig',
			[
				'persona' => $persona
			] );
		$data['html'] = $html;

		return new JsonResponse( [ 'data' => $data ] );

	}

}
