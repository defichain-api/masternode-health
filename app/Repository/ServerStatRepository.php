<?php

namespace App\Repository;

use App\Enum\ServerStatTypes;
use App\Models\ApiKey;
use App\Models\ServerStat;
use Illuminate\Support\Collection;

class ServerStatRepository
{
    public function getLatestServerStatForApiKey(ApiKey $apiKey): Collection
    {
        return ServerStat::where('api_key_id', $apiKey->id)
            ->orderByDesc('created_at')
            ->whereIn('type', ServerStatTypes::SERVER_STATS)
            ->get()
            ->unique('type')
            ->flatten();
    }

    public function getLatestNodeInfoForApiKey(ApiKey $apiKey): Collection
    {
        return ServerStat::where('api_key_id', $apiKey->id)
            ->orderByDesc('created_at')
            ->whereIn('type', ServerStatTypes::NODE_INFO)
            ->get()
            ->unique('type')
            ->flatten();
    }
}
