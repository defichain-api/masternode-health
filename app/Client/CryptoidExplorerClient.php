<?php

namespace App\Client;

use App\Exceptions\Client\CryptoidClientException;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Str;

class CryptoidExplorerClient
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('client_uri.main_net.cryptoid'),
        ]);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws CryptoidClientException
     */
    public function getLatestBlockHeight(): int
    {
        return cache()->remember('cryptoid.block_height', now()->addSeconds(30), function () {
            $response = $this->client->request('get', '?q=getblockcount');
            throw_if($response->getStatusCode() !== JsonResponse::HTTP_OK,
                CryptoidClientException::latestBlockHeight());

            return $response->getBody()->getContents();
        });
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws CryptoidClientException
     */
    public function getLatestBlockHash(int $blockHeight): string
    {
        return cache()->remember(
            sprintf('cryptoid.block_hash.%s', $blockHeight),
            now()->addHour(),
            function () use ($blockHeight) {
                $response = $this->client->request('get', sprintf('?q=getblockhash&height=%s', $blockHeight));
                throw_if($response->getStatusCode() !== JsonResponse::HTTP_OK,
                    CryptoidClientException::latestBlockHash($blockHeight));

                return Str::replace('"', '', $response->getBody()->getContents());
            });
    }
}
