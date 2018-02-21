<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ClubJugador;
use AppBundle\Entity\Contacto;
use AppBundle\Entity\FichaMedica;
use AppBundle\Entity\Jugador;
use AppBundle\Entity\Persona;
use AppBundle\Entity\ResponsableJugador;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AjaxController extends Controller {
	public function getSexosAction() {

		$entities = $this->getDoctrine()->getRepository( 'AppBundle:Sexo' )->findBy( [
			'activo' => true
		] );


		if ( ! count( $entities ) ) {
			$json[] = array(
				'label' => 'No se encontraron coincidencias',
				'value' => ''
			);

			return new JsonResponse( $json, 204 );

		} else {
			foreach ( $entities as $entity ) {
				$json[] = array(
					'id'     => $entity->getId(),
					'nombre' => $entity->getNombre()
				);
			}
		}

		return new JsonResponse( $json );
	}

	public function getTiposIdentificacionAction() {

		$entities = $this->getDoctrine()->getRepository( 'AppBundle:TipoIdentificacion' )->findBy( [
			'activo' => true
		] );


		if ( ! count( $entities ) ) {
			$json[] = array(
				'label' => 'No se encontraron coincidencias',
				'value' => ''
			);

			return new JsonResponse( $json, 204 );

		} else {
			foreach ( $entities as $entity ) {
				$json[] = array(
					'id'     => $entity->getId(),
					'nombre' => $entity->getNombre()
				);
			}
		}

		return new JsonResponse( $json );
	}

	public function getClubAction() {

		$entities = $this->getDoctrine()->getRepository( 'AppBundle:Club' )->findAll();


		if ( ! count( $entities ) ) {
			$json[] = array(
				'label' => 'No se encontraron coincidencias',
				'value' => ''
			);

			return new JsonResponse( $json, 204 );

		} else {
			foreach ( $entities as $entity ) {
				$json[] = array(
					'id'     => $entity->getId(),
					'nombre' => $entity->getNombre()
				);
			}
		}

		return new JsonResponse( $json );
	}

	public function getPosicionAction() {

		$entities = $this->getDoctrine()->getRepository( 'AppBundle:PosicionJugador' )->findBy( [
			'activo' => true
		] );


		if ( ! count( $entities ) ) {
			$json[] = array(
				'label' => 'No se encontraron coincidencias',
				'value' => ''
			);

			return new JsonResponse( $json, 204 );

		} else {
			foreach ( $entities as $entity ) {
				$json[] = array(
					'id'     => $entity->getId(),
					'nombre' => $entity->getNombre()
				);
			}
		}

		return new JsonResponse( $json );
	}

	public function getTextoFichaMedicaAction( Request $request ) {
		$em = $this->getDoctrine();

		$textoFichaMedica = $em->getRepository( 'AppBundle:Texto' )->findOneBySlug( 'datos-ficha-medica' );


		return new JsonResponse( $textoFichaMedica->getCuerpo() );
	}

	public function getTextoConsentimientoAction( Request $request ) {
		$em = $this->getDoctrine();

		$textoConsentimiento = $em->getRepository( 'AppBundle:Texto' )->findOneBySlug( 'precompetitivo-consentimiento' );


		return new JsonResponse( $textoConsentimiento->getCuerpo() );
	}

	public function getGrupoSanguineoAction( Request $request ) {
		$em = $this->getDoctrine();

		$entities = $em->getRepository( 'AppBundle:GrupoSanguineo' )->findBy(
			[ 'activo' => true ]
		);


		if ( ! count( $entities ) ) {
			$json[] = array(
				'label' => 'No se encontraron coincidencias',
				'value' => ''
			);

			return new JsonResponse( $json, 204 );

		} else {
			foreach ( $entities as $entity ) {
				$json[] = array(
					'id'     => $entity->getId(),
					'nombre' => $entity->getNombre()
				);
			}
		}

		return new JsonResponse( $json );
	}


	public function getTipoRelacionAction( Request $request ) {
		$em = $this->getDoctrine();

		$entities = $em->getRepository( 'AppBundle:TipoRelacion' )->findBy(
			[ 'activo' => true ]
		);


		if ( ! count( $entities ) ) {
			$json[] = array(
				'label' => 'No se encontraron coincidencias',
				'value' => ''
			);

			return new JsonResponse( $json, 204 );

		} else {
			foreach ( $entities as $entity ) {
				$json[] = array(
					'id'     => $entity->getId(),
					'nombre' => $entity->getNombre()
				);
			}
		}

		return new JsonResponse( $json );
	}

	public function postPrecompetitivoAction( Request $request ) {

		$em = $this->getDoctrine()->getManager();

		$data = $request->getContent();
		$data = json_decode( $data, true )['data'];

		if ( $data ) {
			$persona = new Persona();

			$persona->setNombre( $data['nombre'] );
			$persona->setApellido( $data['apellido'] );
			$sexo = $em->getRepository( 'AppBundle:Sexo' )->find( $data['sexo']['id'] );
			$persona->setSexo( $sexo );

			$tipoIdentificacion = $em->getRepository( 'AppBundle:TipoIdentificacion' )->find( $data['tipoIdentificacion']['id'] );
			$persona->setTipoIdentificacion( $tipoIdentificacion );

			$persona->setNumeroIdentificacion( $data['numeroIdentificacion'] );
			$fechaNacimiento = \DateTime::createFromFormat( 'd/m/Y', $data['fechaNacimiento'] );
			$persona->setFechaNacimiento( $fechaNacimiento );

			$contacto = new Contacto();
			$contacto->setDireccion( $data['direccion'] );
			$contacto->setTelefono( $data['telefono'] );
			$contacto->setTelefonoAlternativa( $data['telefonoAlternativo'] );
			$contacto->setMail( $data['mail'] );

			$persona->setContacto( $contacto );

			$jugador = new Jugador();
			$jugador->setAltura( $data['altura'] );
			$jugador->setPeso( $data['peso'] );
			$posicionHabitual = $em->getRepository( 'AppBundle:PosicionJugador' )->find( $data['posicionHabitual']['id'] );
			$jugador->setPosicionHabitual( $posicionHabitual );

			if ( $data['posicionAlternativa'] ) {
				$posicionAlternativa = $em->getRepository( 'AppBundle:PosicionJugador' )->find( $data['posicionAlternativa']['id'] );
				$jugador->setPosicionAlternativa( $posicionAlternativa );
			}

			if ( $data['segundaPosicionAlternativa'] ) {
				$segundaPosicionAlternativa = $em->getRepository( 'AppBundle:PosicionJugador' )->find( $data['segundaPosicionAlternativa']['id'] );
				$jugador->setSegundaPosicionAlternativa( $segundaPosicionAlternativa );
			}

//			si es menor

			if ( strtoupper( $data['categoria'] ) == 'INFANTIL' ) {
				$responsable = new Persona();
				$responsable->setNombre( $data['responsableNombre'] );
				$responsable->setApellido( $data['responsableApellido'] );
				$tipoIdentificacionResponsable = $em->getRepository( 'AppBundle:TipoIdentificacion' )->find( $data['responsableTipoIdentificacion']['id'] );
				$responsable->setTipoIdentificacion( $tipoIdentificacionResponsable );
				$responsable->setNumeroIdentificacion( $data['responsableNumeroIdentificacion'] );

				$contactoResponsable = new Contacto();
				$contactoResponsable->setMail( $data['responsableMail'] );
				$contactoResponsable->setTelefono( $data['responsableTelefono'] );
				$contactoResponsable->setDireccion( $data['direccion'] );

				$responsable->setContacto( $contactoResponsable );

				$responsableJugador = new ResponsableJugador();
				$responsableJugador->setJugador( $jugador );
				$responsableJugador->setPersona( $responsable );
				$tipoRelacion = $em->getRepository( 'AppBundle:TipoRelacion' )->find( $data['responsableRelacion']['id'] );
				$responsableJugador->setTipoRelacion( $tipoRelacion );
				$em->persist( $responsableJugador );
			}

//			$jugador->setDivision();

			$clubJugador = new ClubJugador();
			$cub         = $em->getRepository( 'AppBundle:Club' )->find( $data['club']['id'] );
			$clubJugador->setClub( $cub );
			$clubJugador->setConsentimiento( true );

			$jugador->addClubJugador( $clubJugador );

			$persona->setJugador( $jugador );
			$jugador->setPersona( $persona );

			$fichaMedica = new FichaMedica();
			$fichaMedica->setClubJugador( $clubJugador );
			$grupoSanguineo = $em->getRepository( 'AppBundle:GrupoSanguineo' )->find( $data['grupoSanguineo']['id'] );
			$fichaMedica->setGrupoSanguineo( $grupoSanguineo );
			$fichaMedica->setPrestador( $data['prestador'] );
			$fichaMedica->setNumeroAfiliado( $data['numeroAfiliado'] );
			$fichaMedica->setTieneCobertura( $data['tieneCobertura'] ? true : false );
			$em->persist( $fichaMedica );


			$token = md5( uniqid( 'urp_' ) );

			$clubJugador->setJugador( $persona->getJugador() );
			$clubJugador->setTokenConfirmacion( $token );
			$clubJugador->setAnio( date( "Y" ) );

			$em->persist( $persona );

			$em->flush();
			if ( strtoupper( $data['categoria'] ) == 'INFANTIL' ) {
				$this->enviarMailPrecompetitivo( $token, $responsable->getContacto()->getMail(), $persona );
			} else {
				$this->enviarMailPrecompetitivo( $token, $persona->getContacto()->getMail(), $persona );
			}


			$urlOk = $this->generateUrl( 'jugador_precompetitivo_ok' );

			return new JsonResponse( $urlOk );
		} else {
			return new JsonResponse( false, 500 );
		}

	}

	public function enviarMailPrecompetitivo( $token, $mail, $persona ) {
		$mailer = $this->get( 'mailer' );

//		$body   = $request->get( 'cuerpo' );

		$asunto = $this->getParameter( 'site_name' ) . ' - Confirmación Precompetitivo';

		$url = $this->get( 'router' )->generate( 'confirmacion_precompetitivo',
			array( 'token' => $token ),
			UrlGeneratorInterface::ABSOLUTE_URL );

		$message = ( new \Swift_Message( $asunto ) )
			->setFrom( $this->container->getParameter( 'mailer_user' ), $this->getParameter( 'union_name' ) )
			->setTo( $mail )
			->setBody(
//				$body,
				$this->renderView(
				// app/Resources/views/Emails/registration.html.twig
					'emails/precompetitivo.html.twig',
					[
						'nombre' => $persona->getNombre() . ' ' . $persona->getApellido(),
						'url'    => $url
					]
				),
				'text/html'
			)/*
                 * If you also want to include a plaintext version of the message
                ->addPart(
                    $this->renderView(
                        'Emails/registration.txt.twig',
                        array('name' => $name)
                    ),
                    'text/plain'
                )
                */
		;

		$mailer->send( $message );
//		$this->get( 'session' )->getFlashBag()->add( 'info', 'El mail se envió con éxito!' );
	}
}
