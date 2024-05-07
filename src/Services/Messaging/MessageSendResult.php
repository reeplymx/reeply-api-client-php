<?php

declare(strict_types=1);

namespace Reeply\ApiClient\Services\Messaging;

use Reeply\ApiClient\Http\ApiResponse;

class MessageSendResult
{
    /** @var string|null */
    private $id;

    /** @var string */
    private $code;

    /** @var bool */
    private $success;

    public function __construct(ApiResponse $response)
    {
        $responseData = $response->jsonResponse();

        $this->id = empty($responseData['data']['id']) ? null : (string) $responseData['data']['id'];
        $this->code = $responseData['code'];
        $this->success = (bool) $responseData['success'];
    }

    public function id(): ?string
    {
        return $this->id;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function success(): bool
    {
        return $this->success;
    }
}
