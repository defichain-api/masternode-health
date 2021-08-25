<?php

namespace App\Api\v1\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\ServerStat */
class ServerStatCollection extends ResourceCollection
{
    public $collects = ServerStatResource::class;

    public function toArray($request): array
    {
        return [
            'data'          => $this->collection,
            'latest_update' => $this->collection->first()->updated_at,
        ];
    }
}
