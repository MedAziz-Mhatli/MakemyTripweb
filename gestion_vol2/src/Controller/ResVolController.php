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
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;  
use Symfony\Bridge\Twig\Mime\TemplatedEmail;



class ResVolController extends AbstractController
    /**
     * @Route("/resvol")
     */
{
    /**
     * @Route("/verife", name="resVol")
     */

    public function index(): Response
    {
        return $this->render('res_vol/verife.html.twig', [
            'controller_name' => 'ResVolController',
        ]);
    }

        /**
     * @Route("/new", name="resVol_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $em ,Res_Vol $Res_Vol = null): Response
    {
        if (!$Res_Vol){ 
        $Res_Vol = new Res_Vol();}
        $form =$this->createForm(ResvolType::class, $Res_Vol);
        $form -> handleRequest($request);
        
        if ($form -> isSubmitted() && $form -> isValid()) {
            
           
            
            $em->persist($Res_Vol);
            $em->flush();
            return $this->redirectToRoute('resVol');
        }
        return $this->render('res_vol/index.html.twig', [
            'form' => $form -> createView()
        ]);
    
    }

    /**
     * @Route("/edit/{id}", name="resVol_edit", methods={"GET", "POST"})
     */
    public function edit(ResVolRepository $Repository , $id , Request $request, EntityManagerInterface $em): Response
    {
        $resVol = $Repository ->find($id);
        $form = $this -> createForm(ResvolType::class, $resVol);
        $form -> handleRequest($request);
        
        if ($form -> isSubmitted() && $form -> isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($resVol);
            $em->flush();
            return $this ->redirectToRoute('resVol');
        }
        return $this->render('res_vol/index.html.twig',[
            'form' => $form -> createView()
        ]);
    }

    
   /**
     * @Route("/contact", name="contact")
     */

    public function mail( resVol $resVol = null ,MailerInterface $mailer)
    {


        $email = (new TemplatedEmail())
               ->From('mohamedsahraoui.guesmi@esprit.tn')
               ->To('sahraoui.guesmi@gmail.com')
               ->htmlTemplate('res_vol/mail.html.twig')
               ->context([ 'resVol'=>$resVol]);
            
           ;

           $mailer->send($email);

           return $this->redirectToRoute('resvol');
        

               }
   

}
