<?php

namespace App\Controller;

use App\Entity\GuideTouristique;
use App\Form\GuideTouristiqueType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/guide/touristique")
 */
class GuideTouristiqueController extends AbstractController
{
    /**
     * @Route("/", name="app_guide_touristique_index", methods={"GET","POST"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $guideTouristiques = $entityManager
            ->getRepository(GuideTouristique::class)
            ->findAll();

        return $this->render('guide_touristique/index.html.twig', [
            'guide_touristiques' => $guideTouristiques,
        ]);
    }

    /**
     * @Route("/new", name="app_guide_touristique_new", methods={"GET", "POST"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $entityManager) : Response
    {
        $guideTouristique = new GuideTouristique();
        $form = $this->createForm(GuideTouristiqueType::class, $guideTouristique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($guideTouristique);
            $entityManager->flush();
            return $this->redirectToRoute('app_guide_touristique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('guide_touristique/new.html.twig', [
            'guide_touristique' => $guideTouristique,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idGuide}", name="app_guide_touristique_show", methods={"GET"})
     */
    public function show(GuideTouristique $guideTouristique): Response
    {
        return $this->render('guide_touristique/show.html.twig', [
            'guide_touristique' => $guideTouristique,
        ]);
    }

    /**
     * @Route("/{idGuide}/edit", name="app_guide_touristique_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, GuideTouristique $guideTouristique, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GuideTouristiqueType::class, $guideTouristique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_guide_touristique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('guide_touristique/edit.html.twig', [
            'guide_touristique' => $guideTouristique,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idGuide}", name="app_guide_touristique_delete", methods={"GET","POST"})
     */
    public function delete(Request $request, GuideTouristique $guideTouristique, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$guideTouristique->getIdGuide(), $request->request->get('_token'))) {
            $entityManager->remove($guideTouristique);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_guide_touristique_index', [], Response::HTTP_SEE_OTHER);
    }
}
