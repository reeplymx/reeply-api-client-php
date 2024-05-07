<?php

declare(strict_types=1);

namespace Reeply\ApiClient\Http;

class ApiResponse
{
    /**
     * @var string|null
     */
    private $response;

    /**
     * @var array|null
     */
    private $responseData;

    /**
     * @var string|null
     */
    private $headers;

    /**
     * @var int
     */
    private $httpCode;

    public function __construct(
        int $httpCode,
        string $responseBody = null,
        string $headers = null
    ) {
        $this->response = $responseBody;
        $this->headers = $headers;
        $this->httpCode = $httpCode;
    }

    public function rawResponse(): ?string
    {
        return $this->response;
    }

    public function jsonResponse(): ?array
    {
        if (empty($this->response)) {
            return null;
        }

        if ($this->responseData === null) {
            $this->responseData = json_decode($this->response, true);
        }

        return $this->responseData;
    }

    public function headers(): ?string
    {
        return $this->headers;
    }

    public function httpCode(): int
    {
        return $this->httpCode;
    }

    public function hasError(): bool
    {
        $response = $this->jsonResponse();

        return !empty($response['error']);
    }

    public function error(): array
    {
        if (!$this->hasError()) {
            return [];
        }

        $response = $this->jsonResponse();
        return $response['error'];
    }
}
