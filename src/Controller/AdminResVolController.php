<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ResVolRepository;
use App\Entity\Res_Vol;
use App\Form\ResvolType;
/**
 * @Route("/admin/resVol")
 */

class AdminResVolController extends AbstractController

{
    /**
     * @Route("/", name="admin_resVol")
     */
    public function index(ResVolRepository $repository): Response
    {
        return $this->render('adminResvol/index.html.twig', [
            'ResVols' => $repository->findAll()
        ]);
    }



    /**
     * @Route("/delete/{id}", name="admin_resVol_delete")
     */
    public function delete(ResVolRepository $Repository , $id ,Request $request, EntityManagerInterface $em): Response
    {
        $Repository = $Repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($Repository);
        $em->flush();
        return $this->redirectToRoute('admin_resVol', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route ("/search" ,name="search")
     */
    function search (ResVolRepository $ResVolRepository, Request $request) {
        $data = $request -> get('search');
        $ResVol = $ResVolRepository ->findBy( ['compagnie_aerienne'=> $data]);
        return $this -> render('adminResvol/index.html.twig' ,[
                'ResVols' => $ResVol
            ]
        );


    }

}