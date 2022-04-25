<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Offre;
use App\Form\AdminType;
use App\Form\OffreType;
use App\Repository\AdminRepository;
use App\Repository\UserRepository;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use phpDocumentor\Reflection\Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UserType;

use App\Entity\User;
use App\Form\User\EditType;
use App\Form\User\RegistrationType;
use App\Form\User\RequestResetPasswordType;
use App\Form\User\ResetPasswordType;
use App\Security\LoginFormAuthenticator;
use App\Service\CaptchaValidator;
use App\Service\Mailer;
use App\Service\TokenGenerator;
use http\Url;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormError;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailTransportFactory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Bridge\Google\Smtp\GmailTransport;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class AdminController extends AbstractController
{

    /**
     * @Route("/listUser", name="listeUser")
     */
    public function listUser()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('Admin/user/list.html.twig', array("users" => $users));
    }

    /**
     * @Route("/deleteUser/{id}", name="deleteUser")
     */
    public function deleteUser($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute("listeUser");
    }



    /**
     * @Route("/updateUser/{id}", name="updateUser")
     */
    public function updateUser(Request $request, $id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form->add('modifier', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listeUser');
        }
        return $this->render("Admin/user/update.html.twig", array('form' => $form->createView()));
    }


    /**
     * @param UserRepository $repository
     * return Response
     * @Route("/listDQlU", name="listDQLU")
     */
    function orderByNameDQL(UserRepository $repository)
    {
        $users = $repository->orderByName();
        return $this->render('Admin/user/list.html.twig', array("users" => $users));

    }





}
