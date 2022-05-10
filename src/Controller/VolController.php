<?php

namespace App\Controller;

use App\Entity\Vol ;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VolRepository;

/**
 * @Route("/Vol")
 */
class VolController extends AbstractController

{
    /**
     * @Route("/", name="Vol")
     */
    public function index(): Response
    {
        $Vols=$this->getDoctrine()->getRepository(Vol::class)->findAll();
        return $this->render('vol/index.html.twig', [
            'controller_name' => 'VolController',
            'Vols' => $Vols
        ]);
    }

    /**
     * @Route("/view/{id}", name="view_Vol")
     */
    public function viewVol($id){
        $Vol=$this->getDoctrine()->getRepository(Vol::class)->find($id);

        return $this->render('vol/Vol.html.twig',
            ['Vol'=>$Vol]);
    }
}
