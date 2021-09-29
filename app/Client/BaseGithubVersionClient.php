<?php

namespace App\Client;

use App\Exceptions\Client\GithubClientException;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;

abstract class BaseGithubVersionClient
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    final protected function loadLatestInfo(): array
    {
        $response = $this->client->get('');
        throw_if($response->getStatusCode() !== JsonResponse::HTTP_OK,
            GithubClientException::requestFailed(self::class));

        return json_decode($response->getBody()->getContents(), true);
    }

    abstract public function getCurrentVersion(): string;
}
