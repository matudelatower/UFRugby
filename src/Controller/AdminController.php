<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends EasyAdminController {


	private $passwordEncoder;

	public function __construct( UserPasswordEncoderInterface $passwordEncoder ) {
		$this->passwordEncoder = $passwordEncoder;
	}

//	Usuario

	public function listUsuarioAction() {
		if ( ! $this->isGranted( "ROLE_ADMIN" ) ) {

			return $this->redirectToRoute( 'easyadmin',
				[ 'entity' => 'Usuario', 'action' => 'edit', 'id' => $this->getUser()->getId() ] );
		}

		return $this->listAction();
	}

	public function persistUsuarioEntity( $user ) {
		$user->setPassword( $this->passwordEncoder->encodePassword(
			$user,
			$this->request->get( 'usuario' )['plainPassword']
		) );
		parent::persistEntity( $user );
	}

//
	public function updateUsuarioEntity( $user ) {
		if ( $this->request->get( 'user' ) && $this->request->get( 'user' )['plainPassword'] ) {
			$user->setPassword( $this->passwordEncoder->encodePassword(
				$user,
				$this->request->get( 'usuario' )['plainPassword']
			) );
		}
		parent::updateEntity( $user );

	}

}
