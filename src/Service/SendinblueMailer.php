<?php


namespace App\Service;

use Exception;
use GuzzleHttp\Client;
use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Model\SendSmtpEmail;
use SendinBlue\Client\Model\SendSmtpEmailTo;
/*require('/srv/app/src/vendor/autoload.php');*/
class SendinblueMailer
{
    private string $sendinblueApiKey;

    public function __construct(string $sendinblueApiKey)
    {
        $this->sendinblueApiKey = $sendinblueApiKey;
    }

    public function sendEmail($to, $subject, $body)
    {
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $this->sendinblueApiKey);
        $apiInstance = new TransactionalEmailsApi(new Client(), $config);

        $sendSmtpEmail = new SendSmtpEmail([
            'to' => [new SendSmtpEmailTo(['email' => $to])],
            'subject' => $subject,
            'htmlContent' => $body,
            'sender' => ['name' => 'Challenge', 'email' => 'idirwalidhakim31@gmail.com']
        ]);

        try {
            $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
            return $result;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
