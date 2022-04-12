<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Form\ReadType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\HttpFoundation\JsonResponse;

class HotelController extends AbstractController
{
    /**
     * @Route("/hotel", name="app_hotel")
     */
    public function index(): Response
    {
        return $this->render('hotel/index.html.twig', [
            'controller_name' => 'HotelController',
        ]);
    }

    /**
     * @Route("/read", name="read")
     */
    public function read(){
        $liste=$this->getDoctrine()
            ->getRepository(Hotel::class)->findAll();
        return $this->render('hotel/read.html.twig',['tab'=>$liste]);

    }

    /**
     * @Route("/readfront", name="readfront")
     */
    public function readfront(){
        $liste=$this->getDoctrine()
            ->getRepository(Hotel::class)->findAll();
        return $this->render('frontapp/readf.html.twig', ['ta'=>$liste]);

    }
    /**
     * @Route("/delete/{id}",name="delete")
     */
    public function delete($id){
        $objSupp=$this->getDoctrine()->getRepository(Hotel::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($objSupp);
        $em->flush();
        return $this->redirectToRoute('read');
    }
    /**
     * @param Request $request
     * @Route("/create",name="create")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function create(Request $request)
    {
        $hotel=new Hotel();

        $form=$this->
        createForm(ReadType::class,$hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted()&& ($form->isValid()))
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($hotel);
            $em->flush();
            return $this->redirectToRoute('read');}
        else
        { return
            $this->render('hotel/create.html.twig', ['f'=>$form->createView()]);
        }

    }
    /**
     * @Route("/update/{id}",name="modifier")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function update($id, Request $request)
    {$objModif=$this->getDoctrine()
        ->getRepository(Hotel::class)
        ->find($id);
        $form=$this->createForm
        (ReadType::class,$objModif);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid())
        {$em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('read');}
        else
        { return
            $this->render
            ('hotel/update.html.twig',
                ['f'=>$form->createView()]);}


    }
}
