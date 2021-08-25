<?php

namespace App\Api\v1\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\ServerStat */
class ServerStatCollection extends ResourceCollection
{
    public $collects = ServerStatResource::class;

    public function toArray($request): array
    {
        $firstElement = $this->collection->first();

        return [
            'data' => $this->collection,
            $this->mergeWhen(isset($firstElement), function () use ($firstElement) {
                return ['latest_update' => $firstElement->updated_at];
            }),
        ];
    }
}
