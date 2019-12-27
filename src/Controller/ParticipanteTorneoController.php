<?php

namespace App\Controller;

use App\Entity\ParticipanteTorneo;
use App\Entity\Torneo;
use App\Form\ParticipanteTorneoType;
use App\Repository\ParticipanteTorneoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/participante/torneo")
 */
class ParticipanteTorneoController extends Controller {
	/**
	 * @Route("/", name="participante_torneo_index", methods="GET")
	 */
	public function index( ParticipanteTorneoRepository $participanteTorneoRepository ): Response {
		return $this->render( 'participante_torneo/index.html.twig',
			[ 'participante_torneos' => $participanteTorneoRepository->findAll() ] );
	}

	/**
	 * @Route("/new", name="participante_torneo_new", methods="GET|POST")
	 */
	public function new( Request $request ): Response {
		$participanteTorneo = new ParticipanteTorneo();
		$form               = $this->createForm( ParticipanteTorneoType::class, $participanteTorneo );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->persist( $participanteTorneo );
			$em->flush();

			return $this->redirectToRoute( 'participante_torneo_index' );
		}

		return $this->render( 'participante_torneo/new.html.twig',
			[
				'participante_torneo' => $participanteTorneo,
				'form'                => $form->createView(),
			] );
	}

	/**
	 * @Route("/{id}", name="participante_torneo_show", methods="GET")
	 */
	public function show( ParticipanteTorneo $participanteTorneo ): Response {
		return $this->render( 'participante_torneo/show.html.twig', [ 'participante_torneo' => $participanteTorneo ] );
	}

	/**
	 * @Route("/{id}/edit", name="participante_torneo_edit", methods="GET|POST")
	 */
	public function edit( Request $request, ParticipanteTorneo $participanteTorneo ): Response {
		$form = $this->createForm( ParticipanteTorneoType::class, $participanteTorneo );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute( 'participante_torneo_edit', [ 'id' => $participanteTorneo->getId() ] );
		}

		return $this->render( 'participante_torneo/edit.html.twig',
			[
				'participante_torneo' => $participanteTorneo,
				'form'                => $form->createView(),
			] );
	}

	/**
	 * @Route("/{id}", name="participante_torneo_delete", methods="DELETE")
	 */
	public function delete( Request $request, ParticipanteTorneo $participanteTorneo ): Response {
		if ( $this->isCsrfTokenValid( 'delete' . $participanteTorneo->getId(), $request->request->get( '_token' ) ) ) {
			$em = $this->getDoctrine()->getManager();
			$em->remove( $participanteTorneo );
			$em->flush();
		}

		return $this->redirectToRoute( 'participante_torneo_index' );
	}

	/**
	 * @Route("/{torneo}/agregar", name="participante_torneo_agregar", methods="GET|POST")
	 */
	public function agregarATorneo( Request $request, Torneo $torneo ): Response {

		$participanteTorneo = new ParticipanteTorneo();
		$participanteTorneo->setTorneo( $torneo );
		$form = $this->createForm( ParticipanteTorneoType::class, $participanteTorneo );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->persist( $participanteTorneo );
			$em->flush();

			return $this->redirectToRoute( 'participante_torneo_index' );
		}

		return $this->render( 'participante_torneo/new.html.twig',
			[
				'participante_torneo' => $participanteTorneo,
				'form'                => $form->createView(),
			] );
	}
}
