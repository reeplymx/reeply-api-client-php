<?php

declare(strict_types=1);

namespace Reeply\ApiClient\Services\Messaging;

use Reeply\ApiClient\Contracts\ApiClientInterface;
use Reeply\ApiClient\Contracts\ServiceInterface;
use Reeply\ApiClient\Http\ApiRequestException;
use Reeply\ApiClient\Http\ApiResponse;

class Messaging implements ServiceInterface
{
    /**
     * @var ApiClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $basePath = '/messaging';

    public function __construct(ApiClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Send an SMS message
     *
     * @throws ApiRequestException
     */
    public function sendSms(string $number, string $message): MessageSendResult
    {
        return $this->send(
            $this->basePath . '/v1/sms/text/send',
            [
                'number' => $number,
                'message' => $message,
            ]
        );
    }

    /**
     * Send a message to WhatsApp with free text
     *
     * @throws ApiRequestException
     */
    public function sendWhatsAppText(string $number, string $message): MessageSendResult
    {
        return $this->send(
            $this->basePath . '/v1/whatsapp/text/send',
            [
                'number' => $number,
                'message' => $message,
            ]
        );
    }

    /**
     * Send a message to WhatsApp with a template
     *
     * @throws ApiRequestException
     */
    public function sendWhatsAppTemplate(string $number, string $name, string $language, array $components): MessageSendResult
    {
        return $this->send(
            $this->basePath . '/v1/whatsapp/template/send',
            [
                'number' => $number,
                'template' => [
                    'name' => $name,
                    'language' => $language,
                    'components' => $components,
                ],
            ]
        );
    }

    /**
     * Send a message
     *
     * @throws ApiRequestException
     */
    public function send(string $endpoint, array $data): MessageSendResult
    {
        $result = $this->client->post($endpoint, $data);

        return new MessageSendResult($result);
    }
}
