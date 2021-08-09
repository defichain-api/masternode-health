<?php

namespace App\Service;

use App\Api\v1\Requests\ServerStatsRequest;
use App\Enum\ServerStatTypes;
use App\Models\ServerStat;

class ServerStatService
{
    public function store(ServerStatsRequest $request): void
    {
        $data = collect([
            [
                'server_id' => $request->userServer()->id,
                'type'      => ServerStatTypes::CPU,
                'value'     => $request->cpu(),
            ],
            [
                'server_id' => $request->userServer()->id,
                'type'      => ServerStatTypes::HDD_TOTAL,
                'value'     => $request->hddTotal(),
            ],
            [
                'server_id' => $request->userServer()->id,
                'type'      => ServerStatTypes::HDD_USED,
                'value'     => $request->hddUsed(),
            ],
            [
                'server_id' => $request->userServer()->id,
                'type'      => ServerStatTypes::RAM_TOTAL,
                'value'     => $request->ramTotal(),
            ],
            [
                'server_id' => $request->userServer()->id,
                'type'      => ServerStatTypes::RAM_USED,
                'value'     => $request->ramUsed(),
            ],
        ]);
        $data->each(function (array $item) {
            ray(ServerStat::updateOrCreate([
                'server_id' => $item['server_id'],
                'type'      => $item['type'],
            ], $item));
        });
    }
}
