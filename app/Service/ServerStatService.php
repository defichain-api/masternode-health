<?php

namespace App\Service;

use App\Api\v1\Requests\ServerStatsRequest;
use App\Api\v1\Transformer\ServerStatTransformer;
use App\Enum\ServerStatTypes;
use App\Models\ServerStat;

class ServerStatService
{
    public function store(ServerStatsRequest $request): void
    {
        $transformer = new ServerStatTransformer($request);
        $apiKeyId = $transformer->api_key()->id;
        $data = collect([
            [
                'api_key_id' => $apiKeyId,
                'type'       => ServerStatTypes::CPU,
                'value'      => $transformer->cpu(),
            ],
            [
                'api_key_id' => $apiKeyId,
                'type'       => ServerStatTypes::HDD_TOTAL,
                'value'      => $transformer->hddTotal(),
            ],
            [
                'api_key_id' => $apiKeyId,
                'type'       => ServerStatTypes::HDD_USED,
                'value'      => $transformer->hddUsed(),
            ],
            [
                'api_key_id' => $apiKeyId,
                'type'       => ServerStatTypes::RAM_TOTAL,
                'value'      => $transformer->ramTotal(),
            ],
            [
                'api_key_id' => $apiKeyId,
                'type'       => ServerStatTypes::RAM_USED,
                'value'      => $transformer->ramUsed(),
            ],
        ]);
        $data->each(function (array $item) {
            ServerStat::create([
                'api_key_id' => $item['api_key_id'],
                'type'       => $item['type'],
                'value'      => $item['value'],
            ]);
        });
    }
}
