<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Form\OffreType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OffreRepository;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class OffreController extends AbstractController
{
    /**
     * @Route("/home", name="offre")
     */
    public function index(): Response
    {
        return $this->render('Admin/offre/index.html.twig', [
            'controller_name' => 'OffreController',
        ]);
    }

    /**
     * @Route("/listoffre", name="listeoffre")
     */
    public function listOffre()
    {
        $offres = $this->getDoctrine()->getRepository(Offre::class)->findAll();
        return $this->render('Admin/offre/list.html.twig',array("offres" => $offres));
    }

    /**
     * @Route("/deleteoffre/{id}", name="delete")
     */
    public function deleteoffre($id)
    {
        $offre = $this->getDoctrine()->getRepository(offre::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($offre);
        $em->flush();
        return $this->redirectToRoute("listDQL");
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function showoffre($id ,NormalizerInterface  $Normalizer)
    {
        $offre = $this->getDoctrine()->getRepository(Offre::class)->find($id);
        return $this->render('Admin/offre/show.html.twig', array("offre" => $offre));

    }

    /**
     * @Route("/addO", name="addOffre")

     */
    public function addOffre(Request $request)
    {
        $offre = new Offre();
        $form = $this->createForm(OffreType::class, $offre);
        $form->add('ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($offre);
            $em->flush();
            return $this->redirectToRoute('listDQL');
        }


        return $this->render("Admin/offre/add.html.twig", array('form' => $form->createView()));
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function updateOffre(Request $request, $id)
    {
        $offre = $this->getDoctrine()->getRepository(Offre::class)->find($id);
        $form = $this->createForm(OffreType::class, $offre);
        $form->add('modifier', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('listDQL');
        }
        return $this->render("Admin/offre/update.html.twig", array('form1' => $form->createView()));
    }


    /**
     * @param OffreRepository $repository
     * return Response
     * @Route("/listDQl", name="listDQL")
     */
    function orderByDesDQL(OffreRepository $repository)
    {
        $offres = $repository->orderByDesc();
        return $this->render('Admin/offre/list.html.twig', array("offres" => $offres));

    }


    /**
     * @Route("/searchOffre ", name="searchOffre")
     */
    public function searchOffrex(Request $request, NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Offre::class);
        $requestString = $request->get('searchValue');
        $offres = $repository->findOffreByDesc($requestString);
        $jsonContent = $Normalizer->normalize($offres, 'json', ['groups' => '
                 offres']);
        $retour = json_encode($jsonContent);
        return new Response($retour);
    }

}
