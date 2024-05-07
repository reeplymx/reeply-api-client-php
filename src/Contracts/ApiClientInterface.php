<?php

declare(strict_types=1);

namespace Reeply\ApiClient\Contracts;

use Reeply\ApiClient\Http\ApiRequestException;
use Reeply\ApiClient\Http\ApiResponse;

interface ApiClientInterface
{
    const MethodGet = 'GET';
    const MethodPost = 'POST';
    const MethodPut = 'PUT';
    const MethodPatch = 'PATCH';
    const MethodDelete = 'DELETE';

    /**
     * @throws ApiRequestException
     */
    public function get(string $path, array $data = [], bool $useToken = true): ApiResponse;

    /**
     * @throws ApiRequestException
     */
    public function post(string $path, array $data = [], bool $useToken = true): ApiResponse;

    /**
     * @throws ApiRequestException
     */
    public function put(string $path, array $data = [], bool $useToken = true): ApiResponse;

    /**
     * @throws ApiRequestException
     */
    public function patch(string $path, array $data = [], bool $useToken = true): ApiResponse;

    /**
     * @throws ApiRequestException
     */
    public function delete(string $path, array $data = [], bool $useToken = true): ApiResponse;
}
