<?php

namespace App\Api\v1\Resources;

use App\Api\v1\DataAnalyser\BaseAnalyzer;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @see \App\Models\ServerStat
 * @codeCoverageIgnore
 */
class ServerStatCollection extends ResourceCollection
{
    public $collects = ServerStatResource::class;
    protected BaseAnalyzer $analyzer;

    public function __construct($resource, BaseAnalyzer $analyzer)
    {
        parent::__construct($resource);
        $this->analyzer = $analyzer;
    }

    public function toArray($request): array
    {
        $firstElement = $this->collection->first();
        $apiKey = $request->get('api_key');
        /** @var \App\Models\Webhook $webhook */
        $webhook = $apiKey->webhook;

        return [
            'data'     => $this->collection,
            'analysis' => $this->analyzer->analyze()->result(),
            $this->mergeWhen(isset($firstElement), function () use ($firstElement) {
                return ['latest_update' => $firstElement->updated_at];
            }),
            $this->mergeWhen(isset($webhook) && $webhook->reference, function () use ($webhook) {
                return ['reference' => $webhook->reference];
            }),
        ];
    }
}
