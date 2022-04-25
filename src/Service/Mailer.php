<?php
/**
 * Created by PhpStorm.
 * User: giorgiopagnoni
 * Date: 03/07/16
 * Time: 14:24
 */

namespace App\Service;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Routing\RouterInterface;
use FOSUserBundle\Model\UserInterface;
use FOSUserBundle\Mailer\MailerInterface;
use App\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Mailer
{
    protected $mailer;
    protected $router;
    protected $twig;
    protected $logger;
    protected $noreply;

    /**
     * Mailer constructor.
     * @param \Swift_Mailer $mailer
     * @param RouterInterface $router
     * @param LoggerInterface $logger
     * @param string $noreply
     */
    public function __construct(\Swift_Mailer $mailer, RouterInterface $router, LoggerInterface $logger,  $noreply)
    {
        $this->mailer = $mailer;
        $this->router = $router;
        $this->logger = $logger;
        $this->noreply = $noreply;
    }

    /**
     * @param User $user
     * @throws \Exception
     * @throws \Throwable
     */
    public function sendActivationEmailMessage(User $user)
    {
        $url = $this->router->generate('user_activate', ['token' => $user->getToken()], UrlGeneratorInterface::ABSOLUTE_URL);

        $context = [
            'user' => $user,
            'activationUrl' => $url
        ];

        $this->sendMessage('user/email/register-done.html.twig', $context, $this->noreply, $user->getEmail());
    }

    /**
     * @param User $user
     * @throws \Exception
     * @throws \Throwable
     */
    public function sendResetPasswordEmailMessage(User $user)
    {
        $url = $this->router->generate('user_reset_password', ['token' => $user->getToken()], UrlGeneratorInterface::ABSOLUTE_URL);

        $context = [
            'user' => $user,
            'resetPasswordUrl' => $url,
        ];

        $this->sendMessage('user/email/request-password.html.twig', $context, $this->noreply, $user->getEmail());
    }

    /**
     * @param $template string
     * @param $context array
     * @param $fromEmail string
     * @param $toEmail string
     * @throws \Exception
     * @throws \Throwable
     * @return bool
     */
    protected function sendMessage($template, $context, $fromEmail, $toEmail)
    {
        // Create a new mail message.
        $message = (new \Swift_Message('Nouveau compte'));


        $context['images']['top']['src'] = $message->embed(\Swift_Image::fromPath(
            __DIR__.'/../../../web/assets/img/email/header.jpg'

        ));
        $context['images']['bottom']['src'] = $message->embed(\Swift_Image::fromPath(
            __DIR__.'/../../../web/assets/img/email/footer.jpg'
        ));

        $context = $this->twig->mergeGlobals($context);
        $template = $this->twig->loadTemplate($template);
        $subject = $template->renderBlock('subject', $context);
        $textBody = $template->renderBlock('body_text', $context);
        $htmlBody = $template->renderBlock('body_html', $context);

        $message->setSubject($subject);
        $message->setFrom($fromEmail);
        $message->setTo($toEmail);
        $message->setBody($htmlBody, 'text/html');
        $message->addPart($textBody.'text/plain');

        $this->mailer->send($message);
    }
}