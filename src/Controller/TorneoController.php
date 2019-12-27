<?php

namespace App\Controller;

use App\Entity\Torneo;
use App\Form\TorneoType;
use App\Repository\TorneoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/torneo")
 */
class TorneoController extends Controller
{
    /**
     * @Route("/", name="torneo_index", methods="GET")
     */
    public function index(TorneoRepository $torneoRepository): Response
    {

        return $this->render('torneo/index.html.twig', ['torneos' => $torneoRepository->findAll()]);
    }

    /**
     * @Route("/new", name="torneo_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $torneo = new Torneo();
        $form = $this->createForm(TorneoType::class, $torneo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($torneo);
            $em->flush();

	        $this->get( 'session' )->getFlashBag()->add( 'success', 'Torneo Creado correctamente' );

            return $this->redirectToRoute('torneo_index');
        }

        return $this->render('torneo/new.html.twig', [
            'torneo' => $torneo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="torneo_show", methods="GET")
     */
    public function show(Torneo $torneo): Response
    {
        return $this->render('torneo/show.html.twig', ['torneo' => $torneo]);
    }

    /**
     * @Route("/{id}/edit", name="torneo_edit", methods="GET|POST")
     */
    public function edit(Request $request, Torneo $torneo): Response
    {
        $form = $this->createForm(TorneoType::class, $torneo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

	        $this->get( 'session' )->getFlashBag()->add( 'success', 'Torneo Actualizado correctamente' );

            return $this->redirectToRoute('torneo_edit', ['id' => $torneo->getId()]);
        }

        return $this->render('torneo/edit.html.twig', [
            'torneo' => $torneo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="torneo_delete", methods="DELETE")
     */
    public function delete(Request $request, Torneo $torneo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$torneo->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($torneo);
            $em->flush();
        }

        return $this->redirectToRoute('torneo_index');
    }
}
