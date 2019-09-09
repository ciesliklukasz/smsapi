<?php

namespace App\Infrastructure\Communication;

use App\Core\Adapter\MessageSenderAdapter;
use Exception;
use Smsapi\Client\Feature\Sms\Bag\SendSmsBag;
use Smsapi\Client\Feature\Sms\Data\Sms;
use Smsapi\Client\SmsapiHttpClient;

class SMSSenderAdapter implements MessageSenderAdapter
{
    private const TOKEN = '0000000000000000000000000000000000000000';
    /** @var SmsapiHttpClient */
    private $client;

    public function __construct(SmsapiHttpClient $client)
    {
        $this->client = $client;
    }

    public function sendTo(string $recipient, string $content): bool
    {
        try
        {
            $sms = SendSmsBag::withMessage($recipient, $content);
            $sms->from = 'AppComparer';

            $service = $this->client->smsapiComService(self::TOKEN);
            $sms = $service->smsFeature()->sendSms($sms);

            return $sms instanceof Sms;
        }
        catch (Exception $e)
        {
            return false;
        }
    }
}
