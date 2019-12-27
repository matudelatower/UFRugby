<?php

namespace App\Controller;

use App\Entity\EquipoPartido;
use App\Entity\EstadoPartido;
use App\Entity\FechaRonda;
use App\Entity\Partido;
use App\Form\PartidoType;
use App\Repository\PartidoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/partido")
 */
class PartidoController extends Controller {
	/**
	 * @Route("/", name="partido_index", methods="GET")
	 */
	public function index( PartidoRepository $partidoRepository ): Response {
		return $this->render( 'partido/index.html.twig', [ 'partidos' => $partidoRepository->findAll() ] );
	}

	/**
	 * @Route("/new", name="partido_new", methods="GET|POST")
	 */
	public function new( Request $request ): Response {
		$partido = new Partido();
		$form    = $this->createForm( PartidoType::class, $partido );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->persist( $partido );
			$em->flush();

			return $this->redirectToRoute( 'partido_index' );
		}

		return $this->render( 'partido/new.html.twig',
			[
				'partido' => $partido,
				'form'    => $form->createView(),
			] );
	}

	/**
	 * @Route("/{id}", name="partido_show", methods="GET")
	 */
	public function show( Partido $partido ): Response {
		return $this->render( 'partido/show.html.twig', [ 'partido' => $partido ] );
	}

	/**
	 * @Route("/{id}/edit", name="partido_edit", methods="GET|POST")
	 */
	public function edit( Request $request, Partido $partido ): Response {

		$em = $this->getDoctrine()->getManager();

		$form = $this->createForm( PartidoType::class, $partido, [
			'local'=>$partido->getLocal()->getEquipo(),
			'visitante'=>$partido->getVisitante()->getEquipo(),
		] );
		$form->handleRequest( $request );


		if ( $request->getMethod() == "POST" ) {
			if ( $form->get( 'local' )->getData()->getClub() == $form->get( 'visitante' )->getData()->getClub() ) {
				$form->get( 'local' )->addError( new FormError( 'Los equipos no pueden ser iguales' ) );
				$form->get( 'visitante' )->addError( new FormError( 'Los equipos no pueden ser iguales' ) );
			}
		}

		if ( $form->isSubmitted() && $form->isValid() ) {

			$local     = $form->get( 'local' )->getData();
			$visitante = $form->get( 'visitante' )->getData();

			$partido->getLocal()->setEquipo( $local );
			$partido->getVisitante()->setEquipo( $visitante );

			$em->flush();

			$this->get( 'session' )->getFlashBag()->add( 'success', 'Partido actualizado correctamente' );

			return $this->redirectToRoute( 'partido_edit', [ 'id' => $partido->getId() ] );
		}

		return $this->render( 'partido/edit.html.twig',
			[
				'partido' => $partido,
				'form'    => $form->createView(),
			] );
	}

	/**
	 * @Route("/{id}", name="partido_delete", methods="DELETE")
	 */
	public function delete( Request $request, Partido $partido ): Response {
		if ( $this->isCsrfTokenValid( 'delete' . $partido->getId(), $request->request->get( '_token' ) ) ) {
			$em = $this->getDoctrine()->getManager();
			$em->remove( $partido );
			$em->flush();
		}

		return $this->redirectToRoute( 'partido_index' );
	}

	/**
	 * @Route("/{fecha}/agregar-partido", name="partido_agregar", methods="GET|POST")
	 */
	public function agregarPartido( Request $request, FechaRonda $fecha ): Response {
		$em      = $this->getDoctrine()->getManager();
		$partido = new Partido();
		$partido->setFechaRonda( $fecha );
		$estadoPartido = $em->getRepository( EstadoPartido::class )->findOneBySlug( 'pendiente' );
		$partido->setEstado( $estadoPartido );
		$form = $this->createForm( PartidoType::class, $partido );
		$form->handleRequest( $request );

		if ( $request->getMethod() == "POST" ) {
			if ( $form->get( 'local' )->getData()->getClub() == $form->get( 'visitante' )->getData()->getClub() ) {
				$form->get( 'local' )->addError( new FormError( 'Los equipos no pueden ser iguales' ) );
				$form->get( 'visitante' )->addError( new FormError( 'Los equipos no pueden ser iguales' ) );
			}
		}

		if ( $form->isSubmitted() && $form->isValid() ) {

			$equipoLocal     = $form->get( 'local' )->getData();
			$equipoVisitante = $form->get( 'visitante' )->getData();

			$equipoPartidoLocal     = new EquipoPartido();
			$equipoPartidoLocal->setEquipo($equipoLocal);
			$equipoPartidoLocal->setLocal(true);
			$equipoPartidoLocal->setPartido($partido);

			$equipoPartidoVisitante = new EquipoPartido();
			$equipoPartidoVisitante->setEquipo($equipoVisitante);
			$equipoPartidoVisitante->setVisitante(true);
			$equipoPartidoVisitante->setPartido($partido);

			$partido->addEquipoPartido( $equipoPartidoLocal );
			$partido->addEquipoPartido( $equipoPartidoVisitante );

			$em->persist( $partido );
			$em->flush();

			$this->get( 'session' )->getFlashBag()->add( 'success', 'Partido creado correctamente' );

			return $this->redirectToRoute( 'fecha_ronda_show', [ 'id' => $fecha->getId() ] );
		}

		return $this->render( 'partido/agregar.html.twig',
			[
				'partido' => $partido,
				'form'    => $form->createView(),
			] );
	}
}
