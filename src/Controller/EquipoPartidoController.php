<?php

namespace App\Controller;

use App\Entity\EquipoPartido;
use App\Entity\MiembroEquipoPartido;
use App\Form\EquipoPartidoType;
use App\Repository\EquipoPartidoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/equipo/partido")
 */
class EquipoPartidoController extends Controller {
	/**
	 * @Route("/", name="equipo_partido_index", methods="GET")
	 */
	public function index( EquipoPartidoRepository $equipoPartidoRepository ): Response {
		return $this->render( 'equipo_partido/index.html.twig',
			[ 'equipo_partidos' => $equipoPartidoRepository->findAll() ] );
	}

	/**
	 * @Route("/new", name="equipo_partido_new", methods="GET|POST")
	 */
	public function new( Request $request ): Response {
		$equipoPartido = new EquipoPartido();
		$form          = $this->createForm( EquipoPartidoType::class, $equipoPartido );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->persist( $equipoPartido );
			$em->flush();

			return $this->redirectToRoute( 'equipo_partido_index' );
		}

		return $this->render( 'equipo_partido/new.html.twig',
			[
				'equipo_partido' => $equipoPartido,
				'form'           => $form->createView(),
			] );
	}

	/**
	 * @Route("/{id}", name="equipo_partido_show", methods="GET")
	 */
	public function show( EquipoPartido $equipoPartido ): Response {
		return $this->render( 'equipo_partido/show.html.twig', [ 'equipo_partido' => $equipoPartido ] );
	}

	/**
	 * @Route("/{id}/edit", name="equipo_partido_edit", methods="GET|POST")
	 */
	public function edit( Request $request, EquipoPartido $equipoPartido ): Response {
		$form = $this->createForm( EquipoPartidoType::class, $equipoPartido );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute( 'equipo_partido_edit', [ 'id' => $equipoPartido->getId() ] );
		}

		return $this->render( 'equipo_partido/edit.html.twig',
			[
				'equipo_partido' => $equipoPartido,
				'form'           => $form->createView(),
			] );
	}

	/**
	 * @Route("/{id}", name="equipo_partido_delete", methods="DELETE")
	 */
	public function delete( Request $request, EquipoPartido $equipoPartido ): Response {
		if ( $this->isCsrfTokenValid( 'delete' . $equipoPartido->getId(), $request->request->get( '_token' ) ) ) {
			$em = $this->getDoctrine()->getManager();
			$em->remove( $equipoPartido );
			$em->flush();
		}

		return $this->redirectToRoute( 'equipo_partido_index' );
	}

	/**
	 * @Route("/{id}/editar-local", name="equipo_partido_editar_local", methods="GET|POST")
	 */
	public function editarLocal( Request $request, EquipoPartido $equipoPartido ): Response {

		$cantidadTitulares = count( $equipoPartido->getTitulares() );

		for ( $i = ( $cantidadTitulares + 1 ); $i <= $equipoPartido->getPartido()->getFechaRonda()->getRonda()->getTorneo()->getMaximoTitularesPorEquipo(); $i ++ ) {
			$titular = new MiembroEquipoPartido();
			$titular->setTitular( true );
			$titular->setSuplente( false );
			$equipoPartido->addMiembroEquipoPartido( $titular );
		}

		$cantidadSuplentes = count( $equipoPartido->getSuplentes() );

		for ( $i = ( $cantidadSuplentes + 1 ); $i <= $equipoPartido->getPartido()->getFechaRonda()->getRonda()->getTorneo()->getMaximoSuplentesPorEquipo(); $i ++ ) {
			$suplente = new MiembroEquipoPartido();
			$suplente->setTitular( false );
			$suplente->setSuplente( true );
			$equipoPartido->addMiembroEquipoPartido( $suplente );
		}


		$form = $this->createForm( EquipoPartidoType::class,
			$equipoPartido,
			[
				'local' => true,
//				'maximo_por_equipo' => $maximoPorEquipo
			] );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {


			if ( $form->get( 'confirmarEquipo' )->isClicked() ) {
				$equipoPartido->setFechaConfirmacion( new \DateTime( 'now' ) );
			}


			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute( 'equipo_partido_editar_local', [ 'id' => $equipoPartido->getId() ] );
		}

		return $this->render( 'equipo_partido/editar_local.html.twig',
			[
				'equipo_partido' => $equipoPartido,
				'form'           => $form->createView(),
			] );
	}

	/**
	 * @Route("/{id}/editar-visitante", name="equipo_partido_editar_visitante", methods="GET|POST")
	 */
	public function editarVisitante( Request $request, EquipoPartido $equipoPartido ): Response {

		$cantidadTitulares = count( $equipoPartido->getTitulares() );

		for ( $i = ( $cantidadTitulares + 1 ); $i <= $equipoPartido->getPartido()->getFechaRonda()->getRonda()->getTorneo()->getMaximoTitularesPorEquipo(); $i ++ ) {
			$titular = new MiembroEquipoPartido();
			$titular->setTitular( true );
			$titular->setSuplente( false );
			$equipoPartido->addMiembroEquipoPartido( $titular );
		}

		$cantidadSuplentes = count( $equipoPartido->getSuplentes() );

		for ( $i = ( $cantidadSuplentes + 1 ); $i <= $equipoPartido->getPartido()->getFechaRonda()->getRonda()->getTorneo()->getMaximoSuplentesPorEquipo(); $i ++ ) {
			$suplente = new MiembroEquipoPartido();
			$suplente->setTitular( false );
			$suplente->setSuplente( true );
			$equipoPartido->addMiembroEquipoPartido( $suplente );
		}

		$form = $this->createForm( EquipoPartidoType::class,
			$equipoPartido,
			[
				'visitante' => true
			] );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {

			if ( $form->get( 'confirmarEquipo' )->isClicked() ) {
				$equipoPartido->setFechaConfirmacion( new \DateTime( 'now' ) );
			}

			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute( 'equipo_partido_editar_visitante', [ 'id' => $equipoPartido->getId() ] );
		}

		return $this->render( 'equipo_partido/editar_visitante.html.twig',
			[
				'equipo_partido' => $equipoPartido,
				'form'           => $form->createView(),
			] );
	}
}
