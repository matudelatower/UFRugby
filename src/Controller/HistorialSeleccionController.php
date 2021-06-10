<?php

namespace App\Controller;

use App\Entity\HistorialSeleccion;
use App\Entity\Jugador;
use App\Form\HistorialSeleccionType;
use App\Repository\HistorialSeleccionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/historial/seleccion")
 */
class HistorialSeleccionController extends AbstractController {
	/**
	 * @Route("/", name="historial_seleccion_index", methods="GET")
	 */
	public function index( HistorialSeleccionRepository $historialSeleccionRepository ): Response {
		return $this->render( 'historial_seleccion/index.html.twig',
			[ 'historial_seleccions' => $historialSeleccionRepository->findAll() ] );
	}

	/**
	 * @Route("/new", name="historial_seleccion_new", methods="GET|POST")
	 */
	public function new( Request $request ): Response {
		$historialSeleccion = new HistorialSeleccion();
		$form               = $this->createForm( HistorialSeleccionType::class, $historialSeleccion );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->persist( $historialSeleccion );
			$em->flush();

			return $this->redirectToRoute( 'historial_seleccion_index' );
		}

		return $this->render( 'historial_seleccion/new.html.twig',
			[
				'historial_seleccion' => $historialSeleccion,
				'form'                => $form->createView(),
			] );
	}

	/**
	 * @Route("/{id}", name="historial_seleccion_show", methods="GET")
	 */
	public function show( HistorialSeleccion $historialSeleccion ): Response {
		return $this->render( 'historial_seleccion/show.html.twig', [ 'historial_seleccion' => $historialSeleccion ] );
	}

	/**
	 * @Route("/{id}/edit", name="historial_seleccion_edit", methods="GET|POST")
	 */
	public function edit( Request $request, HistorialSeleccion $historialSeleccion ): Response {
		$form = $this->createForm( HistorialSeleccionType::class, $historialSeleccion );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute( 'historial_seleccion_edit', [ 'id' => $historialSeleccion->getId() ] );
		}

		return $this->render( 'historial_seleccion/edit.html.twig',
			[
				'historial_seleccion' => $historialSeleccion,
				'form'                => $form->createView(),
			] );
	}

	/**
	 * @Route("/{id}", name="historial_seleccion_delete", methods="DELETE")
	 */
	public function delete( Request $request, HistorialSeleccion $historialSeleccion ): Response {
		if ( $this->isCsrfTokenValid( 'delete' . $historialSeleccion->getId(), $request->request->get( '_token' ) ) ) {
			$em = $this->getDoctrine()->getManager();
			$em->remove( $historialSeleccion );
			$em->flush();
		}

		return $this->redirectToRoute( 'historial_seleccion_index' );
	}

	/**
	 * @Route("/nuevo-historial-jugador/{jugador}", name="historial_seleccion_jugador_nuevo", methods="GET|POST")
	 */
	public function agregarHistorialAJugador( Request $request, Jugador $jugador ): Response {
		$historialSeleccion = new HistorialSeleccion();
		$historialSeleccion->setJugador( $jugador );
		$form = $this->createForm( HistorialSeleccionType::class, $historialSeleccion );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->persist( $historialSeleccion );
			$em->flush();

			$this->get( 'session' )->getFlashBag()->add( 'success', 'El historial se cargó con exito!' );

			return $this->redirectToRoute( 'jugador_show', [ 'id' => $jugador->getId() ] );
		}

		return $this->render( 'historial_seleccion/new.html.twig',
			[
				'historial_seleccion' => $historialSeleccion,
				'form'                => $form->createView(),
			] );
	}
}
