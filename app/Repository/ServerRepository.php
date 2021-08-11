<?php

namespace App\Repository;

use App\Models\ApiKey;
use App\Models\Server;
use Illuminate\Database\Eloquent\Collection;

class ServerRepository
{
    public function getServersForApiKey(ApiKey $apiKey): Collection
    {
        return Server::whereApiKeyId($apiKey->id)->get();
    }
}
