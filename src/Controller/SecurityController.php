<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 22/05/18
 * Time: 09:53
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Exception\AuthenticationException;


class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        /** @var $session Session */
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $tokenManager = $this->get('security.csrf.token_manager');

        $csrfToken = $tokenManager
            ? $tokenManager->getToken('authenticate')->getValue()
            : null;

//        Configuracion
        $aConfig = $this->getDoctrine()->getRepository('App:Configuracion')->findAll();

        if (!$aConfig) {
            $siglas = $siteName = 'Configurar';
            $logo = false;
        } else {
            $config = $aConfig[0];
            $siteName = $config->getNombreUnion();
            $siglas = $config->getSiglas();
            $logo = $config->getImageName();
        }


        return $this->render('@FOSUser/Security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'site_name' => $siteName,
            'siglas' => $siglas,
            'logo' => $logo,
        ));
    }
}