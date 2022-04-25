<?php
/**

 */

namespace App\Controller;
use App\Form\Security\LoginType;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailTransportFactory;
use Symfony\Component\Routing\Annotation\Route;
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






/**
 * @Route("/user", name="user_")
 */
class UserController extends AbstractController
{
    const DOUBLE_OPT_IN = false;

    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param TokenGenerator $tokenGenerator
     * @param UserPasswordEncoderInterface $encoder
     * @param Mailer $mailer
     * @param CaptchaValidator $captchaValidator
     * @param TranslatorInterface $translator
     * @param $anas
     * @throws \Throwable
     * @return Response
     */
    public function register(Request $request, TokenGenerator $tokenGenerator, UserPasswordEncoderInterface $encoder,\Swift_Mailer $mailer, CaptchaValidator $captchaValidator, TranslatorInterface $translator)
    {
        $form = $this->createForm(RegistrationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();

            try {
                if (!$captchaValidator->validateCaptcha($request->get('g-recaptcha-response'))) {
                    $form->addError(new FormError($translator->trans('captcha.wrong')));
                    throw new ValidatorException('captcha.wrong');
                }

                $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
                $token = $tokenGenerator->generateToken();
                $user->setToken($token);
                $user->setIsActive(false);

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();


                // On crée le message
                $message = (new \Swift_Message(' Activation de votre compte'))
                    // On attribue l'expéditeur
                    ->setFrom('hedil.saidani@esprit.tn')
                    // On attribue le destinataire
                    ->setTo($user->getEmail())
                    // On crée le texte avec la vue
                    ->setBody(
                        $this->renderView(
                            'user/email/activation.html.twig', ['token' => $user->getToken()]
                        ),
                        'text/html'
                    );
                $mailer->send($message);

                $this->addFlash('success', 'Votre inscription est effectuée avec succès !');




            } catch (ValidatorException $exception) {

            }
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
            'captchakey' => $captchaValidator->getKey()

        ]);
    }

    /**
     * @Route("/activate/{token}", name="activate")
     * @param $request Request
     * @param $user User
     * @param $token
     * @param GuardAuthenticatorHandler $authenticatorHandler
     * @param LoginFormAuthenticator $loginFormAuthenticator
     * @return Response
     */
    public function activate(Request $request, User $user, GuardAuthenticatorHandler $authenticatorHandler, LoginFormAuthenticator $loginFormAuthenticator)
    {
        $user->setIsActive(true);
        $user->setToken(null);
        $user->setActivatedAt(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $this->addFlash('success', ' Bienvenue !  ');
        // automatic login
        return $authenticatorHandler->authenticateUserAndHandleSuccess(
            $user,
            $request,
            $loginFormAuthenticator,
            'main'
        );
    }

    /**
     * @Route("/edit", name="edit")
     * @Security("has_role('ROLE_USER')")
     * @param $request Request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function edit(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $origPwd = $this->getUser()->getPassword();
        $form = $this->createForm(EditType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            /** @var User $user */
            $user = $form->getData();
            $pwd = $user->getPassword() ? $encoder->encodePassword($user, $user->getPassword()) : $origPwd;
            $user->setPassword($pwd);
            $em = $this->getDoctrine()->getManager();

            if ($form->isValid()) {
                $em->persist($user);
                $em->flush();
                $this->addFlash('success', 'La modification de votre profil est effectuée avec succès!');

                return $this->redirect($this->generateUrl('homepage'));
            }


            $em->refresh($user);
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/request-password-reset", name="request_password_reset")
     * @param Request $request
     * @param TokenGenerator $tokenGenerator
     * @param  \Swift_Mailer $mailer
     * @param CaptchaValidator $captchaValidator
     * @param TranslatorInterface $translator
     * @param url
     * @throws \Throwable
     * @return Response
     */
    public function requestPasswordReset(Request $request, TokenGenerator $tokenGenerator,
                                         CaptchaValidator $captchaValidator, TranslatorInterface $translator, \Swift_Mailer $mailer): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('reset_password'));
        }

        $form = $this->createForm(RequestResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                if (!$captchaValidator->validateCaptcha($request->get('g-recaptcha-response'))) {
                    $form->addError(new FormError($translator->trans('captcha.wrong')));
                    throw new ValidatorException('captcha.wrong');
                }
                $repository = $this->getDoctrine()->getRepository(User::class);

                /** @var User $user */
                $user = $repository->findOneBy(['email' => $form->get('_username')->getData(), 'isActive' => true]);
                if (!$user) {
                    $this->addFlash('warning', 'Utilisateur inconnu');
                    return $this->render('user/request-password-reset.html.twig', [
                        'form' => $form->createView(),
                        'captchakey' => $captchaValidator->getKey()
                    ]);
                }

                $token = $tokenGenerator->generateToken();
                $user->setToken($token);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $url = $this->generateUrl('user_reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

                // On génère l'e-mail
                $message = (new \Swift_Message('Mot de passe oublié'))
                    ->setFrom('hedil.saidanni@esprit.tn')
                    ->setTo($user->getEmail())
                    ->setBody(
                        "Bonjour,<br><br>Une demande de réinitialisation de mot de passe a été effectuée . Veuillez cliquer sur le lien suivant pour la récupérer : " . $url,
                        'text/html'
                    )
                ;

                // On envoie l'e-mail
                $mailer->send($message);



                $this->addFlash('success', 'Un lien pour réinitialiser votre mot de passe a été envoyé dans votre boîte de réception. Vérifiez-le!');
                return $this->redirect($this->generateUrl('homepage'));
            } catch (ValidatorException $exception) {

            }
        }

        return $this->render('user/request-password-reset.html.twig', [
            'form' => $form->createView(),
            'captchakey' => $captchaValidator->getKey()
        ]);
    }

    /**
     * @Route("/reset-password/{token}", name="reset_password")
     * @param $request Request
     * @param $user User
     * @param $authenticatorHandler GuardAuthenticatorHandler
     * @param $loginFormAuthenticator LoginFormAuthenticator
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function resetPassword(Request $request, User $user, GuardAuthenticatorHandler $authenticatorHandler,
                                  LoginFormAuthenticator $loginFormAuthenticator, UserPasswordEncoderInterface $encoder)
    {
        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('homepage'));
        }

        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            $user->setToken(null);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre mot de passe est  modifié avec succès !');

            // automatic login
            return $authenticatorHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $loginFormAuthenticator,
                'main'
            );
        }

        return $this->render('user/password-reset.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @return Response
     * @route ("/affiche",name="affiche")
     */
    public function affiche(){
        $repo=$this->getDoctrine()->getRepository(User::class);
        $User=$repo->findAll();
        return $this->render('Admin/affiche.html.twig',
            ['User'=>$User]);
    }
    /**

     * @route ("/json",name="json",methods={"GET","POST"})
     */
    public function affichejson(Request $request , NormalizerInterface $Normalizer)
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $User = $repo->findAll();

        $jsonContenat = $Normalizer->normalize($User, 'json',['user' => 'post:read']);


        return new Response(json_encode($jsonContenat));
    }



    /**
     * @Route ("/Search", name="Search", methods={"GET","POST"})
     */

    public function search(Request $request)
    {
        $form = $this;

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->container->get('doctrine')->getManager();
            $user = $em->getRepository('App\Entity\User')->search($data['recherche']);
            return $this->render('Admin/rechercher.html.twig', [
                'User' => $user
            ]);
        }

        return $this->render('Admin/rechercher.html.twig', [
            'form' => $form->createView()
        ]);


    }

    /**
     * @Route("/addjson", name="addjson",methods={"GET","POST"})

     */
    public function addjson(Request $request , NormalizerInterface $Normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $user= new User;
        $user->setEmail($request->get('email'));
        $user->setPassword($request->get('password'));
        $user->setIsActive($request->get('is_active'));
        $user->setName($request->get('name'));
        $user->setToken($request->get('token'));

        $em->persist($user);
        $em->flush();

       $jsonContenat = $Normalizer->normalize($user, 'json',['user' => 'post:read']);


        return new Response(json_encode($jsonContenat));
    }




}
