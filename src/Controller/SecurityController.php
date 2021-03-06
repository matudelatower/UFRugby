<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 22/05/18
 * Time: 09:53
 */

namespace App\Controller;

use App\Entity\Configuracion;
use App\Form\PerfilUsuarioType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController {

	/**
	 * @Route("/login", name="app_login")
	 */
	public function login( AuthenticationUtils $authenticationUtils ): Response {
		if ( $this->getUser() ) {
			return $this->redirectToRoute( 'app_homepage' );
		}

		// Configuracion
		$aConfig = $this->getDoctrine()->getRepository( Configuracion::class )->findAll();

		if ( ! $aConfig ) {
			$siglas = $siteName = 'Configurar';
			$logo   = false;
		} else {
			$config   = $aConfig[0];
			$siteName = $config->getNombreUnion();
			$siglas   = $config->getSiglas();
			$logo     = $config->getImageName();
		}

		// get the login error if there is one
		$error = $authenticationUtils->getLastAuthenticationError();
		// last username entered by the user
		$lastUsername = $authenticationUtils->getLastUsername();

		return $this->render( 'security/login.html.twig',
			[
				'last_username' => $lastUsername,
				'error'         => $error,
				'site_name'     => $siteName,
				'siglas'        => $siglas,
				'logo'          => $logo,
			] );
	}

	/**
	 * @Route("/logout", name="app_logout")
	 */
	public function logout() {
		throw new \LogicException( 'This method can be blank - it will be intercepted by the logout key on your firewall.' );
	}

	/**
	 * @Route("/perfil", name="app_profile")
	 */
	public function perfil( Request $request, UserPasswordEncoderInterface $passwordEncoder ) {

		$em      = $this->getDoctrine()->getManager();
		$usuario = $this->getUser();

		$form = $this->createForm( PerfilUsuarioType::class, $usuario );

		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {

			$passwordPlano = $request->get( 'perfil_usuario' )['passwordPlano']['first'];
			if ( $passwordPlano ) {
				$usuario->setPassword( $passwordEncoder->encodePassword(
					$usuario,
					$passwordPlano
				) );
			}
			$em->flush();

			$this->get( 'session' )->getFlashBag()->add(
				'success',
				'Perfil actualizado correctamente'
			);
		}

		return $this->render( 'security/profile.html.twig',
			[
				'form' => $form->createView()
			] );
	}
}