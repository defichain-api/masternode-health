<?php

namespace App\Api\v1\Resources;

use App\Api\v1\ServerStatTransformer\LoadAvgTransformer;
use App\Api\v1\ServerStatTransformer\RamTotalTransformer;
use App\Api\v1\ServerStatTransformer\RamUsedTransformer;
use App\Enum\ServerStatTypes;
use App\Models\ServerStat;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\ServerStat */
class ServerStatCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data'          => [
                $this->collection->each(function (ServerStat $serverStat) {
                    $this->mergeWhen(
                        $serverStat->type === ServerStatTypes::LOAD_AVG,
                        (new LoadAvgTransformer($serverStat))->getValuePair(),
                    );
                    $this->mergeWhen(
                        $serverStat->type === ServerStatTypes::RAM_USED,
                        (new RamUsedTransformer($serverStat))->getValuePair(),
                    );
                    $this->mergeWhen(
                        $serverStat->type === ServerStatTypes::RAM_TOTAL,
                        (new RamTotalTransformer($serverStat))->getValuePair(),
                    );
                }),
            ],
            'latest_update' => $this->collection->first()->updated_at,
        ];
    }
}
