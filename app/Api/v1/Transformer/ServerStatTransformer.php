<?php

namespace App\Api\v1\Transformer;

use App\Api\v1\Requests\ServerStatsRequest;
use App\Models\ApiKey;
use Str;

class ServerStatTransformer
{
    protected ServerStatsRequest $request;

    public function __construct(ServerStatsRequest $request)
    {
        $this->request = $request;
    }

    public function api_key(): ApiKey
    {
        return $this->request->get('api_key');
    }

    public function cpu(): string
    {
        return $this->request->input('cpu');
    }

    public function hddUsed(): string
    {
        return $this->request->input('hdd_used');
    }

    public function hddTotal(): string
    {
        return $this->request->input('hdd_total');
    }

    public function ramUsed(): string
    {
        return $this->normalizeRam($this->request->input('ram_used'));
    }

    public function ramTotal(): string
    {
        return $this->normalizeRam($this->request->input('ram_total'));
    }

    protected function normalizeRam(string $value): float
    {
        return (float)Str::replace(
            ',',
            '.',
            Str::replace('G', '', $value));
    }
}
