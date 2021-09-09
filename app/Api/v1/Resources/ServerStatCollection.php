<?php

namespace App\Api\v1\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @see \App\Models\ServerStat
 * @codeCoverageIgnore
 */
class ServerStatCollection extends ResourceCollection
{
    public $collects = ServerStatResource::class;

    public function toArray($request): array
    {
        $firstElement = $this->collection->first();
        /** @var \App\Models\Webhook $webhook */
        $webhook = $request->get('api_key')->webhook;

        return [
            'data' => $this->collection,
            $this->mergeWhen(isset($firstElement), function () use ($firstElement) {
                return ['latest_update' => $firstElement->updated_at];
            }),
            $this->mergeWhen(isset($webhook) && $webhook->reference, function () use ($webhook) {
                return ['reference' => $webhook->reference];
            }),
        ];
    }
}
