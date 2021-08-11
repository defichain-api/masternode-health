<?php

namespace App\Service;

use App\Api\v1\Requests\ServerStatsRequest;
use App\Enum\ServerStatTypes;
use App\Models\ServerStat;

class ServerStatService
{
    public function store(ServerStatsRequest $request): void
    {
        $serverId = $request->getServer()->id;
        $data = collect([
            [
                'server_id' => $serverId,
                'type'      => ServerStatTypes::CPU,
                'value'     => $request->cpu(),
            ],
            [
                'server_id' => $serverId,
                'type'      => ServerStatTypes::HDD_TOTAL,
                'value'     => $request->hddTotal(),
            ],
            [
                'server_id' => $serverId,
                'type'      => ServerStatTypes::HDD_USED,
                'value'     => $request->hddUsed(),
            ],
            [
                'server_id' => $serverId,
                'type'      => ServerStatTypes::RAM_TOTAL,
                'value'     => $request->ramTotal(),
            ],
            [
                'server_id' => $serverId,
                'type'      => ServerStatTypes::RAM_USED,
                'value'     => $request->ramUsed(),
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
