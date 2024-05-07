<?php

declare(strict_types=1);

namespace Reeply\ApiClient\Http;

use Reeply\ApiClient\Contracts\ApiClientInterface;

class CurlApiClient implements ApiClientInterface
{
    /**
     * @var string
     */
    private $apiUrl = 'https://api.reeply.mx';

    /**
     * @var string
     */
    private $token;

    /**
     * @var bool
     */
    private $sandbox;

    /**
     * @throws ApiClientException
     */
    public function __construct(string $token, bool $sandbox = false)
    {
        if (empty($token)) {
            throw new ApiClientException('Token is empty');
        }

        $this->token = $token;
        $this->sandbox = $sandbox;
    }

    /**
     * @throws ApiRequestException
     */
    protected function sendRequest(
        string $path,
        string $method = self::MethodGet,
        array $data = [],
        bool $useToken = true
    ): ApiResponse {
        $url = $this->apiUrl . '/' . $path;

        if ($this->sandbox) {
            $url .= '?sandbox=1';
        }

        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
        ];

        if ($useToken) {
            $headers[] = 'Authorization: Bearer ' . $this->token;
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        switch ($method) {
            case self::MethodPost:
                curl_setopt($curl, CURLOPT_POST, count($data));
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case self::MethodPut:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::MethodPut);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case self::MethodPatch:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::MethodPatch);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case self::MethodDelete:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::MethodDelete);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            default:
                if (!empty($data)) {
                    $url .= strpos($url, '?') === false ? '?' : '&';
                    $url .= http_build_query($data);
                }
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 300);
        curl_setopt($curl, CURLOPT_TIMEOUT, 300);

        $response = curl_exec($curl);
        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $responseBody = substr($response, $headerSize);
        $responseHeaders = substr($response, 0, $headerSize);
        $curlErrors = curl_error($curl);

        curl_close($curl);

        if (!empty($curlErrors)) {
            throw new ApiRequestException(
                'Request ' . $method . ' ' . $url . ' failed!',
                $httpCode,
                null,
                $responseBody,
                $responseHeaders,
                $curlErrors
            );
        }

        return new ApiResponse($httpCode, $responseBody, $responseHeaders);
    }

    public function get(string $path, array $data = [], bool $useToken = true): ApiResponse
    {
        return $this->sendRequest($path, self::MethodGet, $data, $useToken);
    }

    public function post(string $path, array $data = [], bool $useToken = true): ApiResponse
    {
        return $this->sendRequest($path, self::MethodPost, $data, $useToken);
    }

    public function put(string $path, array $data = [], bool $useToken = true): ApiResponse
    {
        return $this->sendRequest($path, self::MethodPut, $data, $useToken);
    }

    public function patch(string $path, array $data = [], bool $useToken = true): ApiResponse
    {
        return $this->sendRequest($path, self::MethodPatch, $data, $useToken);
    }

    public function delete(string $path, array $data = [], bool $useToken = true): ApiResponse
    {
        return $this->sendRequest($path, self::MethodDelete, $data, $useToken);
    }
}
