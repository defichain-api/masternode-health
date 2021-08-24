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

    public function cpu(): ?float
    {
        $value = (float) $this->request->input('cpu');

        return is_float($value) ? round($value, 4) : null;
    }

    public function hddUsed(): ?float
    {
        $value = (float) $this->request->input('hdd_used');

        return is_float($value) ? round($value, 4) : null;
    }

    public function hddTotal(): ?float
    {
        $value = (float) $this->request->input('hdd_total');

        return is_float($value) ? round($value, 4) : null;
    }

    public function ramUsed(): ?float
    {
        $value = (float) $this->request->input('ram_used');

        return is_float($value) ? round($value, 4) : null;
    }

    public function ramTotal(): ?float
    {
        $value = (float) $this->request->input('ram_total');

        return is_float($value) ? round($value, 4) : null;
    }
}
