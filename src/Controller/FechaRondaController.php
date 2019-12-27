<?php

namespace App\Controller;

use App\Entity\FechaRonda;
use App\Entity\RondaTorneo;
use App\Form\FechaRondaType;
use App\Repository\FechaRondaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/fecha/ronda")
 */
class FechaRondaController extends Controller {
	/**
	 * @Route("/", name="fecha_ronda_index", methods="GET")
	 */
	public function index( FechaRondaRepository $fechaRondaRepository ): Response {
		return $this->render( 'fecha_ronda/index.html.twig', [ 'fecha_rondas' => $fechaRondaRepository->findAll() ] );
	}

	/**
	 * @Route("/new", name="fecha_ronda_new", methods="GET|POST")
	 */
	public function new( Request $request ): Response {
		$fechaRonda = new FechaRonda();
		$form       = $this->createForm( FechaRondaType::class, $fechaRonda );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->persist( $fechaRonda );
			$em->flush();

			return $this->redirectToRoute( 'fecha_ronda_index' );
		}

		return $this->render( 'fecha_ronda/new.html.twig',
			[
				'fecha_ronda' => $fechaRonda,
				'form'        => $form->createView(),
			] );
	}

	/**
	 * @Route("/{id}", name="fecha_ronda_show", methods="GET")
	 */
	public function show( FechaRonda $fechaRonda ): Response {
		return $this->render( 'fecha_ronda/show.html.twig', [ 'fecha_ronda' => $fechaRonda ] );
	}

	/**
	 * @Route("/{id}/edit", name="fecha_ronda_edit", methods="GET|POST")
	 */
	public function edit( Request $request, FechaRonda $fechaRonda ): Response {
		$form = $this->createForm( FechaRondaType::class, $fechaRonda );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute( 'fecha_ronda_edit', [ 'id' => $fechaRonda->getId() ] );
		}

		return $this->render( 'fecha_ronda/edit.html.twig',
			[
				'fecha_ronda' => $fechaRonda,
				'form'        => $form->createView(),
			] );
	}

	/**
	 * @Route("/{id}", name="fecha_ronda_delete", methods="DELETE")
	 */
	public function delete( Request $request, FechaRonda $fechaRonda ): Response {
		if ( $this->isCsrfTokenValid( 'delete' . $fechaRonda->getId(), $request->request->get( '_token' ) ) ) {
			$em = $this->getDoctrine()->getManager();
			$em->remove( $fechaRonda );
			$em->flush();
		}

		return $this->redirectToRoute( 'fecha_ronda_index' );
	}

	/**
	 * @Route("/{ronda}/agregar-fecha", name="fecha_ronda_agregar", methods="GET|POST")
	 */
	public function agregarFecha( Request $request, RondaTorneo $ronda ): Response {
		$fechaRonda = new FechaRonda();
		$fechaRonda->setRonda( $ronda );
		$form = $this->createForm( FechaRondaType::class, $fechaRonda );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->persist( $fechaRonda );
			$em->flush();

			return $this->redirectToRoute( 'torneo_show', [ 'id' => $ronda->getTorneo()->getId() ] );
		}

		return $this->render( 'fecha_ronda/agregar.html.twig',
			[
				'fecha_ronda' => $fechaRonda,
				'form'        => $form->createView(),
			] );
	}
}
