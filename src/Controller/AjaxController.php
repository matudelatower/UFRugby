<?php

namespace App\Controller;

use App\Entity\ClubJugador;
use App\Entity\Contacto;
use App\Entity\Division;
use App\Entity\FichaMedica;
use App\Entity\InscripcionReferee;
use App\Entity\Jugador;
use App\Entity\Persona;
use App\Entity\PosicionJugador;
use App\Entity\Referee;
use App\Entity\ResponsableJugador;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AjaxController extends Controller {
	public function getSexosAction() {

		$entities = $this->getDoctrine()->getRepository( 'App:Sexo' )->findBy( [
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

		$entities = $this->getDoctrine()->getRepository( 'App:TipoIdentificacion' )->findBy( [
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

		$entities = $this->getDoctrine()->getRepository( 'App:Club' )->findAll();


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

		$entities = $this->getDoctrine()->getRepository( PosicionJugador::class )->findBy( [
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
					'numero'     => $entity->getNumero(),
					'nombre' => $entity->getNombre()
				);
			}
		}

		return new JsonResponse( $json );
	}

	public function getTextoFichaMedicaAction( Request $request ) {
		$em = $this->getDoctrine();

		$textoFichaMedica = $em->getRepository( 'App:Texto' )->findOneBySlug( 'datos-ficha-medica' );


		return new JsonResponse( $textoFichaMedica->getCuerpo() );
	}

	public function getTextoConsentimientoAction( Request $request ) {
		$em = $this->getDoctrine();

		$textoConsentimiento = $em->getRepository( 'App:Texto' )->findOneBySlug( 'precompetitivo-consentimiento' );


		return new JsonResponse( $textoConsentimiento->getCuerpo() );
	}

	public function getGrupoSanguineoAction( Request $request ) {
		$em = $this->getDoctrine();

		$entities = $em->getRepository( 'App:GrupoSanguineo' )->findBy(
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

		$entities = $em->getRepository( 'App:TipoRelacion' )->findBy(
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

			$tipoIdentificacion = $this->getDoctrine()->getRepository( 'App:TipoIdentificacion' )->findOneById( $data['tipoIdentificacion']['id'] );
			$criteria           = [
				'tipoIdentificacion'   => $tipoIdentificacion,
				'numeroIdentificacion' => $data['numeroIdentificacion'],

			];
			$persona            = $this->getDoctrine()->getRepository( 'App:Persona' )->findOneBy( $criteria );

			if ( ! $persona ) {
				$persona = new Persona();

				$persona->setNombre( $data['nombre'] );
				$persona->setApellido( $data['apellido'] );
				$sexo = $em->getRepository( 'App:Sexo' )->find( $data['sexo']['id'] );
				$persona->setSexo( $sexo );

				$tipoIdentificacion = $em->getRepository( 'App:TipoIdentificacion' )->find( $data['tipoIdentificacion']['id'] );
				$persona->setTipoIdentificacion( $tipoIdentificacion );

				$persona->setNumeroIdentificacion( $data['numeroIdentificacion'] );
				$fechaNacimiento = \DateTime::createFromFormat( 'Y-m-d', $data['fechaNacimiento'] );
				$persona->setFechaNacimiento( $fechaNacimiento );

				$contacto = new Contacto();
				$contacto->setDireccion( $data['direccion'] );
				$contacto->setTelefono( $data['telefono'] );
				$contacto->setTelefonoAlternativa( $data['telefonoAlternativo'] );
				$contacto->setMail( $data['mail'] );

				$persona->setContacto( $contacto );
			}

//			is es referee
			if ( strtoupper( $data['categoria'] ) == 'REFEREE' ) {
				$referee            = new Referee();
				$inscripcionReferee = new InscripcionReferee();
				$inscripcionReferee->setAnio( date( "Y" ) );

				$token = md5( uniqid( 'urp_' ) );

				$inscripcionReferee->setTokenConfirmacion( $token );

				$referee->addInscripcionReferee( $inscripcionReferee );

				$persona->addReferee( $referee );

				$em->persist( $persona );

				$em->flush();

				$this->enviarMailReferee( $token, $persona->getContacto()->getMail(), $persona );

				$urlOk = $this->generateUrl( 'referee_inscripcion_ok', [ 'id' => $referee->getId() ] );

				return new JsonResponse( $urlOk );

			} else {
				$jugador = new Jugador();
				$jugador->setAltura( $data['altura'] );
				$jugador->setPeso( $data['peso'] );
				$posicionHabitual = $em->getRepository( 'App:PosicionJugador' )->find( $data['posicionHabitual']['id'] );
				$jugador->setPosicionHabitual( $posicionHabitual );

				if ( $data['posicionAlternativa'] ) {
					$posicionAlternativa = $em->getRepository( 'App:PosicionJugador' )->find( $data['posicionAlternativa']['id'] );
					$jugador->setPosicionAlternativa( $posicionAlternativa );
				}

				if ( $data['segundaPosicionAlternativa'] ) {
					$segundaPosicionAlternativa = $em->getRepository( 'App:PosicionJugador' )->find( $data['segundaPosicionAlternativa']['id'] );
					$jugador->setSegundaPosicionAlternativa( $segundaPosicionAlternativa );
				}

//			si es menor

				if ( strtoupper( $data['categoria'] ) == 'INFANTIL' ) {

					$tipoIdentificacion = $this->getDoctrine()->getRepository( 'App:TipoIdentificacion' )->findOneById( $data['responsableTipoIdentificacion']['id'] );
					$criteria           = [
						'tipoIdentificacion'   => $tipoIdentificacion,
						'numeroIdentificacion' => $data['responsableNumeroIdentificacion'],

					];
					$responsable        = $this->getDoctrine()->getRepository( 'App:Persona' )->findOneBy( $criteria );

					if ( ! $responsable ) {
						$responsable = new Persona();
						$responsable->setNombre( $data['responsableNombre'] );
						$responsable->setApellido( $data['responsableApellido'] );
						$tipoIdentificacionResponsable = $em->getRepository( 'App:TipoIdentificacion' )->find( $data['responsableTipoIdentificacion']['id'] );
						$responsable->setTipoIdentificacion( $tipoIdentificacionResponsable );
						$responsable->setNumeroIdentificacion( $data['responsableNumeroIdentificacion'] );

						$contactoResponsable = new Contacto();
						$contactoResponsable->setMail( $data['responsableMail'] );
						$contactoResponsable->setTelefono( $data['responsableTelefono'] );
						$contactoResponsable->setDireccion( $data['direccion'] );
						$responsable->setContacto( $contactoResponsable );
					}

					$responsableJugador = new ResponsableJugador();
					$responsableJugador->setJugador( $jugador );
					$responsableJugador->setPersona( $responsable );
					$tipoRelacion = $em->getRepository( 'App:TipoRelacion' )->find( $data['responsableRelacion']['id'] );
					$responsableJugador->setTipoRelacion( $tipoRelacion );
					$em->persist( $responsableJugador );
				}

				$clubJugador = new ClubJugador();
				$cub         = $em->getRepository( 'App:Club' )->find( $data['club']['id'] );
				$clubJugador->setClub( $cub );
				$clubJugador->setConfirmado( false );
				$clubJugador->setConfirmadoClub( false );
				$clubJugador->setConfirmadoUnion( false );
				$clubJugador->setConsentimiento( true );

				$jugador->addClubJugador( $clubJugador );

				$persona->addJugador( $jugador );
				$jugador->setPersona( $persona );

				$fichaMedica = new FichaMedica();
				$fichaMedica->setClubJugador( $clubJugador );
				$grupoSanguineo = $em->getRepository( 'App:GrupoSanguineo' )->find( $data['grupoSanguineo']['id'] );
				$fichaMedica->setGrupoSanguineo( $grupoSanguineo );
				$fichaMedica->setPrestador( $data['prestador'] );
				$fichaMedica->setNumeroAfiliado( $data['numeroAfiliado'] );
				$fichaMedica->setTieneCobertura( $data['tieneCobertura'] ? true : false );
				$em->persist( $fichaMedica );

				// division
				$anios = date_diff( date_create( $data['fechaNacimiento'] ), date_create( 'today' ) )->y;

				if ( $anios > 19 ) {
					$division = $em->getRepository( Division::class )->findOneBy( [ 'slug' => 'mayores' ] );
				} elseif ( $anios >= 5 && $anios <= 19 ) {
					$strDiv   = 'm' . $anios;
					$division = $em->getRepository( Division::class )->findOneBy( [ 'slug' => $strDiv ] );
				} elseif ( $anios < 5 ) {
					$division = $em->getRepository( Division::class )->findOneBy( [ 'slug' => 'infantiles' ] );
				}
				$clubJugador->setDivision( $division );

				$token = md5( uniqid( 'urp_' ) );

				$clubJugador->setTokenConfirmacion( $token );
				$clubJugador->setAnio( date( "Y" ) );

				$em->persist( $persona );

				$em->flush();

				if ( strtoupper( $data['categoria'] ) == 'INFANTIL' ) {
					$this->enviarMailPrecompetitivo( $token, $responsable->getContacto()->getMail(), $persona );
				} else {
					$this->enviarMailPrecompetitivo( $token, $persona->getContacto()->getMail(), $persona );
				}

				$urlOk = $this->generateUrl( 'jugador_precompetitivo_ok', [ 'id' => $clubJugador->getId() ] );

				return new JsonResponse( $urlOk );
			}


		} else {
			return new JsonResponse( false, 500 );
		}

	}

	public function enviarMailPrecompetitivo( $token, $mail, $persona ) {
		$mailer = $this->get( 'mailer' );


		$asunto = getenv( 'APP_SITE_NAME' ) . ' - Confirmación Precompetitivo';

		$url = $this->get( 'router' )->generate( 'confirmacion_precompetitivo',
			array( 'token' => $token ),
			UrlGeneratorInterface::ABSOLUTE_URL );

		$message = ( new \Swift_Message( $asunto ) )
			->setFrom( getenv( 'MAILER_USER' ), getenv( 'APP_UNION_NAME' ) )
			->setTo( $mail )
			->setBody(
				$this->renderView(
					'emails/precompetitivo.html.twig',
					[
						'nombre' => $persona->getNombre() . ' ' . $persona->getApellido(),
						'url'    => $url
					]
				),
				'text/html'
			);

		$mailer->send( $message );

	}

	public function enviarMailReferee( $token, $mail, $persona ) {
		$mailer = $this->get( 'mailer' );

		$asunto = getenv( 'APP_SITE_NAME' ) . ' - Confirmación Inscripción';

		$url = $this->get( 'router' )->generate( 'confirmacion_referee',
			array( 'token' => $token ),
			UrlGeneratorInterface::ABSOLUTE_URL );

		$message = ( new \Swift_Message( $asunto ) )
			->setFrom( getenv( 'MAILER_USER' ), getenv( 'APP_UNION_NAME' ) )
			->setTo( $mail )
			->setBody(
				$this->renderView(
					'emails/confirmacion_referee.html.twig',
					[
						'nombre' => $persona->getNombre() . ' ' . $persona->getApellido(),
						'url'    => $url
					]
				),
				'text/html'
			);

		$mailer->send( $message );

	}

	public function getPersonaAction( Request $request ) {


		$tipoIdentificacionId = json_decode( $request->get( 'tipo' ), true );
		$numeroDocumento      = $request->get( 'numero' );


		$tipoIdentificacion = $this->getDoctrine()->getRepository( 'App:TipoIdentificacion' )->findOneById( $tipoIdentificacionId );
		$criteria           = [
			'tipoIdentificacion'   => $tipoIdentificacion,
			'numeroIdentificacion' => $numeroDocumento,

		];
		$persona            = $this->getDoctrine()->getRepository( 'App:Persona' )->findOneBy( $criteria );

		if ( $persona ) {
			$rta = [
				'apellido'            => $persona->getApellido(),
				'nombre'              => $persona->getNombre(),
				'sexo'                => [
					'id'     => $persona->getSexo()->getId(),
					'nombre' => $persona->getSexo()->getNombre()
				],
				'fechaNacimiento'     => $persona->getFechaNacimiento()->format( 'Y-m-d' ),
				'direccion'           => $persona->getContacto()->getDireccion(),
				'telefono'            => $persona->getContacto()->getTelefono(),
				'telefonoAlternativo' => $persona->getContacto()->getTelefonoAlternativa(),
				'mail'                => $persona->getContacto()->getMail(),
			];

			return new JsonResponse( $rta );
		} else {
			return new JsonResponse( 'No se encontró un jugador', 404 );
		}
	}
}
