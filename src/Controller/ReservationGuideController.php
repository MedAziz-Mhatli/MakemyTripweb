<?php

namespace App\Controller;

use App\Entity\ReservationGuide;
use App\Form\ReservationGuideType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reservation/guide")
 */
class ReservationGuideController extends AbstractController
{
    /**
     * @Route("/", name="app_reservation_guide_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reservationGuides = $entityManager
            ->getRepository(ReservationGuide::class)
            ->findAll();

        return $this->render('reservation_guide/index.html.twig', [
            'reservation_guides' => $reservationGuides,
        ]);
    }

    /**
     * @Route("/new", name="app_reservation_guide_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservationGuide = new ReservationGuide();
        $form = $this->createForm(ReservationGuideType::class, $reservationGuide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservationGuide);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_guide_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation_guide/new.html.twig', [
            'reservation_guide' => $reservationGuide,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idResguide}", name="app_reservation_guide_show", methods={"GET"})
     */
    public function show(ReservationGuide $reservationGuide): Response
    {
        return $this->render('reservation_guide/show.html.twig', [
            'reservation_guide' => $reservationGuide,
        ]);
    }

    /**
     * @Route("/{idResguide}/edit", name="app_reservation_guide_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ReservationGuide $reservationGuide, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationGuideType::class, $reservationGuide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_guide_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation_guide/edit.html.twig', [
            'reservation_guide' => $reservationGuide,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idResguide}", name="app_reservation_guide_delete", methods={"POST"})
     */
    public function delete(Request $request, ReservationGuide $reservationGuide, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservationGuide->getIdResguide(), $request->request->get('_token'))) {
            $entityManager->remove($reservationGuide);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_guide_index', [], Response::HTTP_SEE_OTHER);
    }
}
