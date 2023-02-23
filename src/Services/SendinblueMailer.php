<?php


namespace App\Services;
use Exception;
use GuzzleHttp\Client;
use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Model\SendSmtpEmail;
use SendinBlue\Client\Model\SendSmtpEmailTo;
class SendinblueMailer
{
    private string $sendinblueApiKey;

    public function __construct(string $sendinblueApiKey)
    {
        $this->sendinblueApiKey = $sendinblueApiKey;
    }

    public function sendEmail($to, $subject, $body)
    {
        $twig = new \Twig\Environment(new \Twig\Loader\FilesystemLoader('../templates/emails'));
        $body = $twig->render('confirmation_email.html.twig', ['name' => 'soheib']);
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $this->sendinblueApiKey);
        
        $apiInstance = new TransactionalEmailsApi(new Client(), $config);

        $sendSmtpEmail = new SendSmtpEmail([
            'to' => [new SendSmtpEmailTo(['email' => $to])],
            'subject' => $subject,
            'htmlContent' => $body,
            'sender' => ['name' => 'Challenge', 'email' => 'soheib.hadef@gmail.com']
        ]);

        try {
            $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
            return $result;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}