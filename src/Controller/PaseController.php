<?php

namespace App\Controller;

use App\Entity\ClubJugador;
use App\Entity\Jugador;
use App\Entity\Pase;
use App\Form\PaseAceptarType;
use App\Form\PaseRechazarType;
use App\Form\PaseType;
use App\Repository\PaseRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pase")
 */
class PaseController extends AbstractController {
	/**
	 * @Route("/", name="pase_index", methods="GET")
	 */
	public function index( Request $request, PaseRepository $paseRepository, PaginatorInterface $paginator ): Response {

		if ( $this->isGranted( 'ROLE_ADMIN' ) ) {
			$pases = $paseRepository->findQbAll();
		} elseif ( $this->isGranted( 'ROLE_UNION' ) ) {
			$pases = $paseRepository->findQbPendientesUnion();
		} elseif ( $this->isGranted( 'ROLE_CLUB' ) ) {
			$pases = [];
		}

		$pases = $paginator->paginate(
			$pases, /* query NOT result */
			$request->query->getInt( 'page', 1 )/*page number*/,
			10/*limit per page*/
		);

		return $this->render( 'pase/index.html.twig', [ 'pases' => $pases ] );
	}

	/**
	 * @Route("/new", name="pase_new", methods="GET|POST")
	 */
	public
	function new(
		Request $request
	): Response {
		$pase = new Pase();
		$form = $this->createForm( PaseType::class, $pase );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->persist( $pase );
			$em->flush();

			return $this->redirectToRoute( 'pase_index' );
		}

		return $this->render( 'pase/new.html.twig',
			[
				'pase' => $pase,
				'form' => $form->createView(),
			] );
	}

	/**
	 * @Route("/{id}", name="pase_show", methods="GET", requirements={"id":"\d+"})
	 */
	public function show( Pase $pase ): Response {
		return $this->render( 'pase/show.html.twig', [ 'pase' => $pase ] );
	}

	/**
	 * @Route("/{id}/edit", name="pase_edit", methods="GET|POST")
	 */
	public function edit( Request $request, Pase $pase ): Response {
		$form = $this->createForm( PaseType::class, $pase );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute( 'pase_edit', [ 'id' => $pase->getId() ] );
		}

		return $this->render( 'pase/edit.html.twig',
			[
				'pase' => $pase,
				'form' => $form->createView(),
			] );
	}

	/**
	 * @Route("/{id}", name="pase_delete", methods="DELETE")
	 */
	public function delete( Request $request, Pase $pase ): Response {
		if ( $this->isCsrfTokenValid( 'delete' . $pase->getId(), $request->request->get( '_token' ) ) ) {
			$em = $this->getDoctrine()->getManager();
			$em->remove( $pase );
			$em->flush();
		}

		return $this->redirectToRoute( 'pase_index' );
	}

	/**
	 * @Route("/{jugador}/solicitar-pase", name="solicitar_pase", methods="GET|POST")
	 */
	public function solicitarPase( Request $request, Jugador $jugador ) {

		$em = $this->getDoctrine()->getManager();

		$clubDestino = $this->getUser()->getClub();

		$pase = new Pase();
		$pase->setJugador( $jugador );
		$clubOrigen = $jugador->getClubJugador()->last()->getClub();
		$pase->setClubOrigen( $clubOrigen );
		$pase->setClubDestino( $clubDestino );

		$form = $this->createForm( PaseType::class, $pase );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {


			$existeSolicitud = $em->getRepository( Pase::class )->findOneBy( [
				'jugador'     => $jugador,
				'clubDestino' => $clubDestino,
				'activo'      => true
			] );

			if ( $existeSolicitud ) {
				$this->get( 'session' )->getFlashBag()->add(
					'warning',
					'Ya existe una solicitud para este jugador'
				);

				return $this->redirectToRoute( 'pase_index' );
			}

			$pase->setConfirmacionClub( false );
			$pase->setConfirmacionUnion( false );
			$pase->setEstado( 'Pendiente' );

			$em->persist( $pase );
			$em->flush();

			$this->get( 'session' )->getFlashBag()->add(
				'success',
				'Solicitud de pase creada correctamente!'
			);

			return $this->redirectToRoute( 'pase_solicitudes_enviadas' );
		}

		if ( $pase->getClubOrigen() == $pase->getClubDestino() ) {
			$this->get( 'session' )->getFlashBag()->add(
				'warning',
				'El jugador pertenece a su Club'
			);

			return $this->redirectToRoute( 'buscar_jugador' );
		}

		$referer = null;
		if ( $request->get( 'referer' ) ) {
			$referer = $request->get( 'referer' );
		}

		return $this->render( 'pase/solicitar.html.twig',
			[
				'pase'    => $pase,
				'jugador' => $jugador,
				'referer' => $referer,
				'form'    => $form->createView(),
			] );


	}

	public function solicitudesEnviadas( Request $request, PaginatorInterface $paginator ): Response {

		$em = $this->getDoctrine()->getManager();

		$club = $this->getUser()->getClub();

		$pases = $em->getRepository( Pase::class )->findQbSolicitudesEnviadas( $club );

		$pases = $paginator->paginate(
			$pases, /* query NOT result */
			$request->query->getInt( 'page', 1 )/*page number*/,
			10/*limit per page*/
		);

		return $this->render( 'pase/index.html.twig', [ 'pases' => $pases ] );
	}

	public function solicitudesRecibidas( Request $request, PaginatorInterface $paginator ): Response {

		$em = $this->getDoctrine()->getManager();

		$club = $this->getUser()->getClub();

		$pases = $em->getRepository( Pase::class )->findQbSolicitudesRecibidas( $club );

		$pases = $paginator->paginate(
			$pases, /* query NOT result */
			$request->query->getInt( 'page', 1 )/*page number*/,
			10/*limit per page*/
		);

		return $this->render( 'pase/index.html.twig', [ 'pases' => $pases ] );
	}

	public function rechazarClub( Request $request, Pase $pase ) {

		$em = $this->getDoctrine()->getManager();

		$form = $this->createForm( PaseRechazarType::class, $pase );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {

			$pase->setConfirmacionClub( false );
			$pase->setConfirmacionUnion( false );
			$pase->setEstado( 'Rechazada' );
			$pase->setActivo( false );

			$em->flush();

			$this->get( 'session' )->getFlashBag()->add(
				'success',
				'Solicitud de pase rechazada correctamente!'
			);

			return $this->redirectToRoute( 'pase_solicitudes_recibidas' );
		}

		$backRoute = $this->generateUrl( 'pase_solicitudes_recibidas' );

		return $this->render( 'pase/rechazar.html.twig',
			[
				'pase'      => $pase,
				'backRoute' => $backRoute,
				'form'      => $form->createView(),
			] );
	}

	public function aceptarClub( Request $request, Pase $pase ) {
		$em = $this->getDoctrine()->getManager();

		$form = $this->createForm( PaseAceptarType::class, $pase );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {

			$pase->setConfirmacionClub( true );
			$pase->setFechaConfirmacionClub( new \DateTime( 'now' ) );
			$pase->setConfirmacionUnion( false );
			$pase->setEstado( 'Pendiente (Unión)' );

			$em->flush();

			$this->get( 'session' )->getFlashBag()->add(
				'success',
				'Solicitud de pase aceptada correctamente!'
			);

			return $this->redirectToRoute( 'pase_solicitudes_recibidas' );
		}

		$backRoute = $this->generateUrl( 'pase_solicitudes_recibidas' );

		return $this->render( 'pase/aceptar.html.twig',
			[
				'pase'      => $pase,
				'backRoute' => $backRoute,
				'form'      => $form->createView(),
			] );
	}

	public function rechazarUnion( Request $request, Pase $pase ) {

		$em = $this->getDoctrine()->getManager();

		$form = $this->createForm( PaseRechazarType::class, $pase );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {

			$pase->setConfirmacionUnion( false );
			$pase->setEstado( 'Rechazada' );
			$pase->setActivo( false );

			$em->flush();

			$this->get( 'session' )->getFlashBag()->add(
				'success',
				'Solicitud de pase rechazada correctamente!'
			);

			return $this->redirectToRoute( 'pase_index' );
		}

		$backRoute = $this->generateUrl( 'pase_index' );

		return $this->render( 'pase/rechazar.html.twig',
			[
				'pase'      => $pase,
				'backRoute' => $backRoute,
				'form'      => $form->createView(),
			] );
	}

	public function aceptarUnion( Request $request, Pase $pase ) {
		$em = $this->getDoctrine()->getManager();

		$form = $this->createForm( PaseAceptarType::class, $pase );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {

			$pase->setFechaConfirmacionUnion( new \DateTime( 'now' ) );
			$pase->setConfirmacionUnion( true );
			$pase->setEstado( 'Aprobada' );

			$clubJugador = $pase->getJugador()->getClubJugador()->last();

			if ( ! $clubJugador ) {
				$clubJugador = new ClubJugador();
				$clubJugador->setJugador( $pase->getJugador() );
				$clubJugador->setClub( $pase->getClubDestino() );
				$clubJugador->setConfirmado( true );
				$clubJugador->setConfirmadoClub( true );
				$clubJugador->setFechaConfirmacionClub( new \DateTime( 'now' ) );
				$clubJugador->setConfirmadoUnion( true );
				$clubJugador->setFechaConfirmacionUnion( new \DateTime( 'now' ) );
				$clubJugador->setConsentimiento( true );
				$clubJugador->setAnio( date( "Y" ) );

				$division = $fichaMedica = $pase->getJugador()->getClubJugador()->last()->getDivision();

				$clubJugador->setDivision( $division );

				$fichaMedica = $pase->getJugador()->getClubJugador()->last()->getFichaMedica()->last();
				$clubJugador->addFichaMedica( $fichaMedica );

				$pase->getJugador()->addClubJugador( $clubJugador );

				$em->persist( $clubJugador );
			}

			$em->flush();

			$this->get( 'session' )->getFlashBag()->add(
				'success',
				'Solicitud de pase aceptada correctamente!'
			);

			return $this->redirectToRoute( 'pase_index' );
		}

		$backRoute = $this->generateUrl( 'pase_index' );

		return $this->render( 'pase/aceptar.html.twig',
			[
				'pase'      => $pase,
				'backRoute' => $backRoute,
				'form'      => $form->createView(),
			] );
	}
}
