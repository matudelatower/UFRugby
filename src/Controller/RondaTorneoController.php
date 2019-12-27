<?php

namespace App\Controller;

use App\Entity\RondaTorneo;
use App\Entity\Torneo;
use App\Form\RondaTorneoType;
use App\Repository\RondaTorneoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ronda/torneo")
 */
class RondaTorneoController extends Controller {
	/**
	 * @Route("/", name="ronda_torneo_index", methods="GET")
	 */
	public function index( RondaTorneoRepository $rondaTorneoRepository ): Response {
		return $this->render( 'ronda_torneo/index.html.twig',
			[ 'ronda_torneos' => $rondaTorneoRepository->findAll() ] );
	}

	/**
	 * @Route("/new", name="ronda_torneo_new", methods="GET|POST")
	 */
	public function new( Request $request ): Response {
		$rondaTorneo = new RondaTorneo();
		$form        = $this->createForm( RondaTorneoType::class, $rondaTorneo );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->persist( $rondaTorneo );
			$em->flush();

			return $this->redirectToRoute( 'ronda_torneo_index' );
		}

		return $this->render( 'ronda_torneo/new.html.twig',
			[
				'ronda_torneo' => $rondaTorneo,
				'form'         => $form->createView(),
			] );
	}

	/**
	 * @Route("/{id}", name="ronda_torneo_show", methods="GET")
	 */
	public function show( RondaTorneo $rondaTorneo ): Response {
		return $this->render( 'ronda_torneo/show.html.twig', [ 'ronda_torneo' => $rondaTorneo ] );
	}

	/**
	 * @Route("/{id}/edit", name="ronda_torneo_edit", methods="GET|POST")
	 */
	public function edit( Request $request, RondaTorneo $rondaTorneo ): Response {
		$form = $this->createForm( RondaTorneoType::class, $rondaTorneo );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute( 'ronda_torneo_edit', [ 'id' => $rondaTorneo->getId() ] );
		}

		return $this->render( 'ronda_torneo/edit.html.twig',
			[
				'ronda_torneo' => $rondaTorneo,
				'form'         => $form->createView(),
			] );
	}

	/**
	 * @Route("/{id}", name="ronda_torneo_delete", methods="DELETE")
	 */
	public function delete( Request $request, RondaTorneo $rondaTorneo ): Response {
		if ( $this->isCsrfTokenValid( 'delete' . $rondaTorneo->getId(), $request->request->get( '_token' ) ) ) {
			$em = $this->getDoctrine()->getManager();
			$em->remove( $rondaTorneo );
			$em->flush();
		}

		return $this->redirectToRoute( 'ronda_torneo_index' );
	}

	/**
	 * @Route("/{torneo}/agregar-ronda", name="ronda_torneo_agregar", methods="GET|POST")
	 */
	public function agregarRonda( Request $request, Torneo $torneo ): Response {
		$rondaTorneo = new RondaTorneo();
		$rondaTorneo->setTorneo( $torneo );
		$form = $this->createForm( RondaTorneoType::class, $rondaTorneo );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->persist( $rondaTorneo );
			$em->flush();

			return $this->redirectToRoute( 'torneo_show', [ 'id' => $torneo->getId() ] );
		}

		return $this->render( 'ronda_torneo/agregar.html.twig',
			[
				'ronda_torneo' => $rondaTorneo,
				'form'         => $form->createView(),
			] );
	}
}
