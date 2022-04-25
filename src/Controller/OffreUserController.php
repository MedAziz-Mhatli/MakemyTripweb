<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OffreUserController extends AbstractController
{
    /**
     * @Route("/homeClient", name="home_client")
     */
    public function index(): Response
    {
        return $this->render('user/offre/index.html.twig', [
            'controller_name' => 'OffreUserController',
        ]);
    }




    /**
     * @Route("/listoffreC", name="listeoffreC")
     */
    public function listOffre()
    {
        $offres = $this->getDoctrine()->getRepository(Offre::class)->findAll();
        return $this->render('user/offre/list.html.twig', array("offres" => $offres));
    }


    /**
     * @Route("/showoffreC/{id}", name="showOffreC")
     */
    public function showoffre($id)
    {
        $offre = $this->getDoctrine()->getRepository(Offre::class)->find($id);
        return $this->render('user/offre/show.html.twig', array("offre" => $offre));
    }

    /**
     * @param OffreRepository $repository
     * return Response
     * @Route("/listDQlC", name="listDQLC")
     */
    function orderByDesDQL(OffreRepository $repository)
    {
        $offres = $repository->orderByDesc();
        return $this->render('user/offre/list.html.twig', array("offres" => $offres));

    }


}
