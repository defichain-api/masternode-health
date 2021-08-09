<?php

namespace App\Service;

use App\Models\Server;

class ServerKeyService
{
    public function generateKey(string $apiKey): string
    {
        return Server::create([
            'api_key_id' => $apiKey,
        ])->id;
    }
}
