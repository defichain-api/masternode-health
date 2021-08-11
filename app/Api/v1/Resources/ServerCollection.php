<?php

namespace App\Api\v1\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Server */
class ServerCollection extends ResourceCollection
{
    public $collects = ServerResource::class;
    public function toArray($request): array
    {
        return [
            'data' => $this->collection,
            'info' => [
              'count' => $this->collection->count(),
            ],
        ];
    }
}
