<?php

declare(strict_types=1);

namespace Reeply\ApiClient\Http;

use Exception;
use Throwable;

class ApiRequestException extends Exception
{
    /**
     * @var string|null
     */
    private $response;

    /**
     * @var string|null
     */
    private $headers;

    /**
     * @var string|null
     */
    private $curlErrors;

    public function __construct(
        string $message = '',
        int $httpCode = 0,
        Throwable $previous = null,
        string $responseBody = null,
        string $headers = null,
        string $curlErrors = null
    ) {
        $this->response = $responseBody;
        $this->headers = $headers;
        $this->curlErrors = $curlErrors;

        parent::__construct($message, $httpCode, $previous);
    }

    public function response(): ?string
    {
        return $this->response;
    }

    public function jsonResponse(): ?array
    {
        if (empty($this->response)) {
            return null;
        }

        return json_decode($this->response, true);
    }

    public function headers(): ?string
    {
        return $this->headers;
    }

    public function curlErrors(): ?string
    {
        return $this->curlErrors;
    }
}
