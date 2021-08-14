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
        $serverId = $transformer->server()->id;
        $data = collect([
            [
                'server_id' => $serverId,
                'type'      => ServerStatTypes::CPU,
                'value'     => $transformer->cpu(),
            ],
            [
                'server_id' => $serverId,
                'type'      => ServerStatTypes::HDD_TOTAL,
                'value'     => $transformer->hddTotal(),
            ],
            [
                'server_id' => $serverId,
                'type'      => ServerStatTypes::HDD_USED,
                'value'     => $transformer->hddUsed(),
            ],
            [
                'server_id' => $serverId,
                'type'      => ServerStatTypes::RAM_TOTAL,
                'value'     => $transformer->ramTotal(),
            ],
            [
                'server_id' => $serverId,
                'type'      => ServerStatTypes::RAM_USED,
                'value'     => $transformer->ramUsed(),
            ],
        ]);
        $data->each(function (array $item) {
            ServerStat::create([
                'server_id' => $item['server_id'],
                'type'      => $item['type'],
                'value'     => $item['value'],
            ]);
        });
    }
}
