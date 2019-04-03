<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\Filter\UsuarioFilterType;
use App\Form\UsuarioType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Route("/usuario")
 */
class UsuarioController extends AbstractController
{
    /**
     * @Route("/", name="usuario_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {


        $filterType = $this->createForm(UsuarioFilterType::class,
            null,
            [
                'method' => 'GET'
            ]);

        $filterType->handleRequest($request);

        if ($filterType->get('buscar')->isClicked()) {
            $usuarios = $this->getDoctrine()->getRepository(Usuario::class)->findQbBuscar($filterType->getData());
        } else {
            $usuarios = $this->getDoctrine()
                ->getRepository(Usuario::class)
                ->findQbAll();
        }


        $usuarios = $paginator->paginate(
            $usuarios, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('usuario/index.html.twig', [
            'usuarios' => $usuarios,
            'filter_type' => $filterType->createView()
        ]);
    }

    /**
     * @Route("/new", name="usuario_new", methods={"GET","POST"})
     */
    public function new(Request $request, \Swift_Mailer $mailer): Response
    {
        $usuario = new Usuario();
        $usuario->setPlainPassword(substr(md5(uniqid(rand(), true)), 0, 8));
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPass = $usuario->getPlainPassword();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($usuario);
            $entityManager->flush();

            $this->enviarMailUsuario($usuario->getEmail(), $usuario->getUsername(), $plainPass, $mailer);

            $this->get('session')->getFlashBag()->add('success', 'El usuario se creó con éxito, 
            se envió un mail al usuario con los datos de ingreso');


            return $this->redirectToRoute('usuario_index');
        }

        return $this->render('usuario/new.html.twig', [
            'usuario' => $usuario,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="usuario_show", methods={"GET"})
     */
    public function show(Usuario $usuario): Response
    {
        return $this->render('usuario/show.html.twig', [
            'usuario' => $usuario,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="usuario_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Usuario $usuario): Response
    {
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('usuario_index', [
                'id' => $usuario->getId(),
            ]);
        }

        return $this->render('usuario/edit.html.twig', [
            'usuario' => $usuario,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="usuario_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Usuario $usuario): Response
    {
        if ($this->isCsrfTokenValid('delete' . $usuario->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($usuario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('usuario_index');
    }

    public function enviarMailUsuario($mail, $usuario, $password, $mailer)
    {
//        $mailer = $this->get('mailer');

        $asunto = getenv('APP_SITE_NAME') . ' - Nuevo Usuario';

        $url = $this->get('router')->generate('fos_user_security_login', [],
            UrlGeneratorInterface::ABSOLUTE_URL);

        // TODO agregar no-reply@urp.org.py cuando se cree la casilla
        $message = (new \Swift_Message($asunto))
            ->setFrom(getenv( 'MAILER_USER' ), getenv('APP_UNION_NAME'))
            ->setTo($mail)
            ->setBody(
                $this->renderView(
                    'emails/nuevo_usuario.html.twig',
                    [
                        'nombre' => $usuario,
                        'password' => $password,
                        'url' => $url
                    ]
                ),
                'text/html'
            );

        $mailer->send($message);

    }
}
