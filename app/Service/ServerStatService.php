<?php

namespace App\Service;

use App\Api\v1\Requests\ServerStatsRequest;
use App\Api\v1\RequestTransformer\ServerStatTransformer;
use App\Enum\ServerStatTypes;
use App\Models\ServerStat;
use Illuminate\Support\Collection;

class ServerStatService
{
    public function store(ServerStatsRequest $request): Collection
    {
        $transformer = new ServerStatTransformer($request);
        $apiKeyId = $transformer->api_key()->key();
        $data = collect([
            [
                'api_key_id' => $apiKeyId,
                'type'       => ServerStatTypes::LOAD_AVG,
                'value'      => $transformer->loadAvg(),
            ],
            [
                'api_key_id' => $apiKeyId,
                'type'       => ServerStatTypes::NUM_CORES,
                'value'      => $transformer->numCores(),
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
            [
                'api_key_id' => $apiKeyId,
                'type'       => ServerStatTypes::SERVER_SCRIPT_VERSION,
                'value'      => $transformer->serverScriptVersion(),
            ],
        ]);
        $addedServerStats = new Collection();
        $data->each(function (array $item) use (&$addedServerStats) {
            if (is_null($item['value']) || $item['value'] == 0) {
                return;
            }
            $addedServerStats->add(
                ServerStat::create([
                    'api_key_id' => $item['api_key_id'],
                    'type'       => $item['type'],
                    'value'      => $item['value'],
                ])
            );
        });

        return $addedServerStats;
    }
}
