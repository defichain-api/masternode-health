<?php

namespace App\Api\v1\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name'       => $this->name,
            'server_id'  => $this->id,
            'created_at' => $this->created_at,
        ];
    }
}
