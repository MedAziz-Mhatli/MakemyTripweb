<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Form\ChambreType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChambreController extends AbstractController
{
    /**
     * @Route("/chambre", name="app_chambre")
     */
    public function index(): Response
    {
        return $this->render('chambre/index.html.twig', [
            'controller_name' => 'ChambreController',
        ]);
    }
    /**
     * @Route("/readch", name="readch")
     */
    public function read(){
        $liste=$this->getDoctrine()
            ->getRepository(Chambre::class)->findAll();
        return $this->render('chambre/read.html.twig',['tabb'=>$liste]);

    }
    /**
     * @Route("/deletee/{id}",name="deletee")
     */
    public function deletee($id){
        $objSupp=$this->getDoctrine()->getRepository(Chambre::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($objSupp);
        $em->flush();
        return $this->redirectToRoute('readch');
    }


    /**
     * @param Request $request
     * @Route("/createC",name="createC")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function create(Request $request)
    {$chambre=new Chambre();
        $form=$this->createForm(ChambreType::class,
            $chambre);
        $form->handleRequest($request);
        if ($form ->isSubmitted()&& $form->isValid() )
        {$em=$this->getDoctrine()->getManager();
            $em->persist($chambre);
            $em->flush();
            return $this->redirectToRoute('readch');}
        else

        {
            return $this->
            render('chambre/create.html.twig',
                ['f'=>$form->createView()]);
        }

    }
    /**
     * @Route("/updatech/{id}",name="updatech")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function update($id, Request $request)
    {$objModif=$this->getDoctrine()
        ->getRepository(Chambre::class)
        ->find($id);
        $form=$this->createForm
        (ChambreType::class,$objModif);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid())
        {$em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('readch');}
        else
        { return
            $this->render
            ('chambre/update.html.twig',
                ['f'=>$form->createView()]);}


    }
}
