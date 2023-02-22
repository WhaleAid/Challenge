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
        //$config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $this->sendinblueApiKey);
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key','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' );
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