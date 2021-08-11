<?php

namespace App\Service;

use App\Models\Server;

class ServerService
{
    public function generateKey(string $apiKey, ?string $name): string
    {
        return Server::create([
            'api_key_id' => $apiKey,
            'name'       => $name,
        ])->id;
    }

    public function rename(Server $server, string $newName): bool
    {
        return $server->update([
            'name' => $newName,
        ]);
    }

    public function delete(Server $server): bool
    {
        return $server->delete();
    }
}
