<?php

namespace App\Controller;

use App\Entity\FichaMedica;
use App\Form\FichaMedica1Type;
use App\Repository\FichaMedicaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ficha-medica")
 */
class FichaMedicaController extends AbstractController {
	/**
	 * @Route("/", name="ficha_medica_index", methods="GET")
	 */
	public function index( FichaMedicaRepository $fichaMedicaRepository ): Response {
		return $this->render( 'ficha_medica/index.html.twig',
			[ 'ficha_medicas' => $fichaMedicaRepository->findAll() ] );
	}

	/**
	 * @Route("/new", name="ficha_medica_new", methods="GET|POST")
	 */
	public function new( Request $request ): Response {
		$fichaMedica = new FichaMedica();
		$form        = $this->createForm( FichaMedica1Type::class, $fichaMedica );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->persist( $fichaMedica );
			$em->flush();

			return $this->redirectToRoute( 'ficha_medica_index' );
		}

		return $this->render( 'ficha_medica/new.html.twig',
			[
				'ficha_medica' => $fichaMedica,
				'form'         => $form->createView(),
			] );
	}

	/**
	 * @Route("/{id}", name="ficha_medica_show", methods="GET")
	 */
	public function show( FichaMedica $fichaMedica ): Response {
		return $this->render( 'ficha_medica/show.html.twig', [ 'ficha_medica' => $fichaMedica ] );
	}

	/**
	 * @Route("/{id}/edit", name="ficha_medica_edit", methods="GET|POST")
	 */
	public function edit( Request $request, FichaMedica $fichaMedica ): Response {
		$form = $this->createForm( FichaMedica1Type::class, $fichaMedica );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute( 'ficha_medica_edit', [ 'id' => $fichaMedica->getId() ] );
		}

		return $this->render( 'ficha_medica/edit.html.twig',
			[
				'ficha_medica' => $fichaMedica,
				'form'         => $form->createView(),
			] );
	}

	/**
	 * @Route("/{id}", name="ficha_medica_delete", methods="DELETE")
	 */
	public function delete( Request $request, FichaMedica $fichaMedica ): Response {
		if ( $this->isCsrfTokenValid( 'delete' . $fichaMedica->getId(), $request->request->get( '_token' ) ) ) {
			$em = $this->getDoctrine()->getManager();
			$em->remove( $fichaMedica );
			$em->flush();
		}

		return $this->redirectToRoute( 'ficha_medica_index' );
	}

	/**
	 * @Route("/{id}/editar-ficha-medica-jugador", name="editar_ficha_medica_jugador", methods="GET|POST")
	 */
	public function editarFichaMedicaJugador( Request $request, FichaMedica $fichaMedica ): Response {


		$form = $this->createForm( FichaMedica1Type::class, $fichaMedica );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$this->getDoctrine()->getManager()->flush();

			$this->get( 'session' )->getFlashBag()->add(
				'success',
				'La Ficha Médica se actualizó correctamente'
			);

			return $this->redirectToRoute( 'jugador_show',
				[ 'id' => $fichaMedica->getClubJugador()->getJugador()->getId() ] );
		}

		return $this->render( 'ficha_medica/edit.html.twig',
			[
				'ficha_medica' => $fichaMedica,
				'form'         => $form->createView(),
			] );


	}
}
