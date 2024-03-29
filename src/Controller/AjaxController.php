<?php

namespace App\Controller;

use App\Entity\Club;
use App\Entity\ClubJugador;
use App\Entity\Contacto;
use App\Entity\Division;
use App\Entity\FichaMedica;
use App\Entity\InscripcionReferee;
use App\Entity\Jugador;
use App\Entity\Pase;
use App\Entity\Persona;
use App\Entity\PosicionJugador;
use App\Entity\Referee;
use App\Entity\ResponsableJugador;
use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AjaxController extends AbstractController
{

	private $mailer;

	public function __construct(MailerInterface $mailer)
	{
		$this->mailer = $mailer;
	}

	public function getSexosAction()
	{

		$entities = $this->getDoctrine()->getRepository( 'App:Sexo' )->findBy( [
			'activo' => true
		] );


		if ( ! count( $entities )) {
			$json[] = array(
				'label' => 'No se encontraron coincidencias',
				'value' => ''
			);

			return new JsonResponse( $json, 204 );

		} else {
			foreach ($entities as $entity) {
				$json[] = array(
					'id'     => $entity->getId(),
					'nombre' => $entity->getNombre()
				);
			}
		}

		return new JsonResponse( $json );
	}

	public function getTiposIdentificacionAction()
	{

		$entities = $this->getDoctrine()->getRepository( 'App:TipoIdentificacion' )->findBy( [
			'activo' => true
		] );


		if ( ! count( $entities )) {
			$json[] = array(
				'label' => 'No se encontraron coincidencias',
				'value' => ''
			);

			return new JsonResponse( $json, 204 );

		} else {
			foreach ($entities as $entity) {
				$json[] = array(
					'id'     => $entity->getId(),
					'nombre' => $entity->getNombre()
				);
			}
		}

		return new JsonResponse( $json );
	}

	public function getClubAction()
	{

		$entities = $this->getDoctrine()->getRepository( 'App:Club' )->findAll();


		if ( ! count( $entities )) {
			$json[] = array(
				'label' => 'No se encontraron coincidencias',
				'value' => ''
			);

			return new JsonResponse( $json, 204 );

		} else {
			foreach ($entities as $entity) {
				$json[] = array(
					'id'     => $entity->getId(),
					'nombre' => $entity->getNombre()
				);
			}
		}

		return new JsonResponse( $json );
	}

	public function getPosicionAction()
	{

		$entities = $this->getDoctrine()->getRepository( PosicionJugador::class )->findBy( [
			'activo' => true
		] );


		if ( ! count( $entities )) {
			$json[] = array(
				'label' => 'No se encontraron coincidencias',
				'value' => ''
			);

			return new JsonResponse( $json, 204 );

		} else {
			foreach ($entities as $entity) {
				$json[] = array(
					'id'     => $entity->getId(),
					'numero' => $entity->getNumero(),
					'nombre' => $entity->getNombre()
				);
			}
		}

		return new JsonResponse( $json );
	}

	public function getTextoFichaMedicaAction(Request $request)
	{
		$em = $this->getDoctrine();

		$textoFichaMedica = $em->getRepository( 'App:Texto' )->findOneBySlug( 'datos-ficha-medica' );


		return new JsonResponse( $textoFichaMedica->getCuerpo() );
	}

	public function getTextoConsentimientoAction(Request $request)
	{
		$em = $this->getDoctrine();

		$textoConsentimiento = $em->getRepository( 'App:Texto' )->findOneBySlug( 'precompetitivo-consentimiento' );


		return new JsonResponse( $textoConsentimiento->getCuerpo() );
	}

	public function getGrupoSanguineoAction(Request $request)
	{
		$em = $this->getDoctrine();

		$entities = $em->getRepository( 'App:GrupoSanguineo' )->findBy(
			['activo' => true]
		);


		if ( ! count( $entities )) {
			$json[] = array(
				'label' => 'No se encontraron coincidencias',
				'value' => ''
			);

			return new JsonResponse( $json, 204 );

		} else {
			foreach ($entities as $entity) {
				$json[] = array(
					'id'     => $entity->getId(),
					'nombre' => $entity->getNombre()
				);
			}
		}

		return new JsonResponse( $json );
	}


	public function getTipoRelacionAction(Request $request)
	{
		$em = $this->getDoctrine();

		$entities = $em->getRepository( 'App:TipoRelacion' )->findBy(
			['activo' => true]
		);


		if ( ! count( $entities )) {
			$json[] = array(
				'label' => 'No se encontraron coincidencias',
				'value' => ''
			);

			return new JsonResponse( $json, 204 );

		} else {
			foreach ($entities as $entity) {
				$json[] = array(
					'id'     => $entity->getId(),
					'nombre' => $entity->getNombre()
				);
			}
		}

		return new JsonResponse( $json );
	}

	public function postPrecompetitivoAction(Request $request)
	{

		$em = $this->getDoctrine()->getManager();

		$data = $request->request->all();

//		$data = json_decode( $data, true )['data'];
		try {
			if ($data) {

				$tipoIdentificacion = $this->getDoctrine()->getRepository( 'App:TipoIdentificacion' )->findOneById( $data['tipoIdentificacion']['id'] );
				$criteria           = [
					'tipoIdentificacion'   => $tipoIdentificacion,
					'numeroIdentificacion' => $data['numeroIdentificacion'],

				];
				$persona            = $this->getDoctrine()->getRepository( 'App:Persona' )->findOneBy( $criteria );

				if ( ! $persona) {
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

				} else {
					// si existe la persona	actualiza datos de contacto
					$contacto = $persona->getContacto();

				}

				//		subiendo archivo
				$file = $request->files->get( 'identificacion' );
				if ($file) {
					$fileName = $data['numeroIdentificacion'] . '.' . $file->guessExtension();

					// moves the file to the directory where usuarios are stored
					$file->move(
						$this->getParameter( 'app.path.persona_identificacion' ),
						$fileName
					);

					$persona->setIdentificacionFileName( $fileName );
				}

				//		subiendo archivo

				$contacto->setDireccion( $data['direccion'] );
				$contacto->setTelefono( $data['telefono'] );
				$contacto->setTelefonoAlternativa( $data['telefonoAlternativo'] );
				$contacto->setMail( $data['mail'] );

				$persona->setContacto( $contacto );


//			is es referee
				if (strtoupper( $data['categoria'] ) == 'REFEREE') {
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

					$urlOk = $this->generateUrl( 'referee_inscripcion_ok', ['id' => $referee->getId()] );

					return new JsonResponse( $urlOk );

				} else {

					$jugador = $jugadorPrevio = $em->getRepository( Jugador::class )->findOneBy(
						['persona' => $persona],
						['id' => 'desc'] );

					if ( ! $jugadorPrevio) {
						$jugador = new Jugador();
					}
					$jugador->setAltura( $data['altura'] );
					$jugador->setPeso( $data['peso'] );
					$posicionHabitual = $em->getRepository( 'App:PosicionJugador' )->find( $data['posicionHabitual']['id'] );
					$jugador->setPosicionHabitual( $posicionHabitual );

					if ($data['posicionAlternativa']) {
						$posicionAlternativa = $em->getRepository( 'App:PosicionJugador' )->find( $data['posicionAlternativa']['id'] );
						$jugador->setPosicionAlternativa( $posicionAlternativa );
					}

					if ($data['segundaPosicionAlternativa']) {
						$segundaPosicionAlternativa = $em->getRepository( 'App:PosicionJugador' )->find( $data['segundaPosicionAlternativa']['id'] );
						$jugador->setSegundaPosicionAlternativa( $segundaPosicionAlternativa );
					}

					// si es menor

					if (strtoupper( $data['categoria'] ) == 'INFANTIL') {

						$tipoIdentificacion = $this->getDoctrine()->getRepository( 'App:TipoIdentificacion' )->findOneById( $data['responsableTipoIdentificacion']['id'] );
						$criteria           = [
							'tipoIdentificacion'   => $tipoIdentificacion,
							'numeroIdentificacion' => $data['responsableNumeroIdentificacion'],

						];
						$responsable        = $this->getDoctrine()->getRepository( 'App:Persona' )->findOneBy( $criteria );

						if ( ! $responsable) {
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

					$clubFichaje = $em->getRepository( Club::class )->find( $data['club']['id'] );


					// si tiene fichaje previo
					if ($jugadorPrevio) {
						$fichajePrevio = $em->getRepository( ClubJugador::class )->findOneBy(
							['jugador' => $jugadorPrevio],
							['id' => 'desc'] );

						if ($fichajePrevio && $fichajePrevio->getClub() !== $clubFichaje) {
							// si tiene fichaje previo, genero una solicitud de pase
							$pase = new Pase();
							$pase->setClubOrigen( $fichajePrevio->getClub() );
							$pase->setClubDestino( $clubFichaje );
							$pase->setJugador( $jugador );
							$pase->setEstado( 'Pendiente' );
							$em->persist( $pase );
						}
					}

					$clubJugador = new ClubJugador();

					$clubJugador->setClub( $clubFichaje );
					$clubJugador->setConfirmado( false );

					// por ahora se omitirá la confirmacion del club
					$clubJugador->setConfirmadoClub( true );
					$clubJugador->setFechaConfirmacionClub( new \DateTime( 'now' ) );
					$clubJugador->setConfirmado( true );
					// por ahora se omitirá la confirmacion del club

					$clubJugador->setConfirmadoUnion( false );
					$clubJugador->setConsentimiento( true );

					$jugador->addClubJugador( $clubJugador );

					$persona->addJugador( $jugador );
					$jugador->setPersona( $persona );


					if (strtoupper( $data['categoria'] ) !== 'INFANTIL') {
						$fichaMedica = new FichaMedica();
						$fichaMedica->setClubJugador( $clubJugador );
						$grupoSanguineo = $em->getRepository( 'App:GrupoSanguineo' )->find( $data['grupoSanguineo']['id'] );
						$fichaMedica->setGrupoSanguineo( $grupoSanguineo );
						$fichaMedica->setPrestador( $data['prestador'] );
						$fichaMedica->setNumeroAfiliado( $data['numeroAfiliado'] );
						$fichaMedica->setTieneCobertura( $data['tieneCobertura'] ? true : false );
						$em->persist( $fichaMedica );
					}

					// division
					$anios = date_diff( date_create( $data['fechaNacimiento'] ), date_create( 'today' ) )->y;

					if ($anios > 23) {
						$division = $em->getRepository( Division::class )->findOneBy( ['slug' => 'mayores'] );
					} elseif ($anios >= 5 && $anios <= 23) {
						$strDiv   = 'm' . $anios;
						$division = $em->getRepository( Division::class )->findOneBy( ['slug' => $strDiv] );
					} elseif ($anios < 5) {
						$division = $em->getRepository( Division::class )->findOneBy( ['slug' => 'm5'] );
					}

					$clubJugador->setDivision( $division );

					$token = md5( uniqid( 'urp_' ) );

					$clubJugador->setTokenConfirmacion( $token );
					$clubJugador->setAnio( date( "Y" ) );

					$em->persist( $persona );

					$em->flush();

					if (strtoupper( $data['categoria'] ) == 'INFANTIL') {
						$this->enviarMailPrecompetitivo( $token, $responsable->getContacto()->getMail(), $persona );
					} else {
						$this->enviarMailPrecompetitivo( $token, $persona->getContacto()->getMail(), $persona );
					}

					$urlOk = $this->generateUrl( 'jugador_precompetitivo_ok', ['id' => $clubJugador->getId()] );

					return new JsonResponse( $urlOk );
				}


			} else {
				return new JsonResponse( false, 500 );
			}
		} catch (\Exception $ex) {
			return new JsonResponse( false, 500 );
		}


	}

	public function enviarMailPrecompetitivo($token, $mail, $persona)
	{

		$mailer = $this->mailer;

		$asunto = $_ENV['APP_SITE_NAME'] . ' - Confirmación Precompetitivo';

		$url = $this->get( 'router' )->generate( 'confirmacion_precompetitivo',
			array('token' => $token),
			UrlGeneratorInterface::ABSOLUTE_URL );


		$email = (new Email())
			->from( $_ENV['MAILER_USER'] )
			->to( $mail )
			->html(
				$this->renderView(
					'emails/precompetitivo.html.twig',
					[
						'nombre' => $persona->getNombre() . ' ' . $persona->getApellido(),
						'url'    => $url
					]
				)
			)
			->subject( $asunto );
		$mailer->send( $email );

//		$message = ( new \Swift_Message( $asunto ) )
//			->setFrom( getenv( 'MAILER_USER' ), getenv( 'APP_UNION_NAME' ) )
//			->setTo( $mail )
//			->setBody(
//				$this->renderView(
//					'emails/precompetitivo.html.twig',
//					[
//						'nombre' => $persona->getNombre() . ' ' . $persona->getApellido(),
//						'url'    => $url
//					]
//				),
//				'text/html'
//			);
//
//		$mailer->send( $message );

	}

	public function enviarMailReferee($token, $mail, $persona)
	{
		$mailer = $this->get( 'mailer' );

		$asunto = getenv( 'APP_SITE_NAME' ) . ' - Confirmación Inscripción';

		$url = $this->get( 'router' )->generate( 'confirmacion_referee',
			array('token' => $token),
			UrlGeneratorInterface::ABSOLUTE_URL );

		$message = (new \Swift_Message( $asunto ))
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

	public function getPersonaAction(Request $request)
	{


		$tipoIdentificacionId = json_decode( $request->get( 'tipo' ), true );
		$numeroDocumento      = $request->get( 'numero' );


		$tipoIdentificacion = $this->getDoctrine()->getRepository( 'App:TipoIdentificacion' )->findOneById( $tipoIdentificacionId );
		$criteria           = [
			'tipoIdentificacion'   => $tipoIdentificacion,
			'numeroIdentificacion' => $numeroDocumento,

		];
		$persona            = $this->getDoctrine()->getRepository( 'App:Persona' )->findOneBy( $criteria );

		$clubJugador = $this->getDoctrine()->getRepository( ClubJugador::class )->findSolicitudPendiente( $persona );

		$estadoFichaje = null;
		if (count( $clubJugador ) >= 1) {
			$fichaje       = $clubJugador[0];
			$estadoFichaje = [
				'pendienteJugador' => $fichaje->getConfirmado(),
				'pendienteClub'    => $fichaje->getConfirmadoClub(),
				'pendienteUnion'   => $fichaje->getConfirmadoUnion(),
			];
		}

		if ($persona) {
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
				'estadoFichaje'       => $estadoFichaje
			];

			return new JsonResponse( $rta );
		} else {
			return new JsonResponse( 'No se encontró un jugador', 404 );
		}
	}

	public function getUsuarios()
	{
		$usuarios = $this->getDoctrine()
		                 ->getManager()
		                 ->getRepository( Usuario::class )
		                 ->findBy( ['enabled' => true] );
		$usuarios = array_map( function (Usuario $usuario) {
			return [
				'id'       => $usuario->getId(),
				'username' => $usuario->getUsername(),
				'nombre'   => $usuario->getPersona() ? $usuario->getPersona()->__toString() : null,
				'club'     => $usuario->getClub() ? $usuario->getClub()->__toString() : null,
				'roles'    => $usuario->getRoles(),
			];
		},
			$usuarios );

		return JsonResponse::create( $usuarios );
	}

}
