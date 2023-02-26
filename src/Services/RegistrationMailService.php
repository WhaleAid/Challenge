<?php

namespace App\Services;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegistrationMailService
{
    private $mailer;
    private $router;

    public function __construct(SendinblueMailer $mailer, UrlGeneratorInterface $router)
    {
        $this->mailer = $mailer;
        $this->router = $router;
    }

    public function sendValidationEmail(string $email, string $token)
    {
        $url = $this->router->generate('registration_validation', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

        $email = (new TemplatedEmail())
            ->from('idirwalidhakim31@gmail.com')
            ->to($email)
            ->subject('Activate your account')
            ->htmlTemplate('emails/registration_validation.html.twig')
            ->context([
                'url' => $url,
            ]);

        $this->mailer->sendEmail($email,'Activate your account',$email);
    }
}