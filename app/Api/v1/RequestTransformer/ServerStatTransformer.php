<?php

namespace App\Api\v1\RequestTransformer;

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

    public function loadAvg(): float
    {
        $value = (float)$this->request->input('load_avg', 0);

        return is_float($value) ? round($value, 4) : 0;
    }

    public function numCores(): int
    {
        return (int)$this->request->input('num_cores', 0);
    }

    public function hddUsed(): float
    {
        $value = (float)$this->request->input('hdd_used', 0);

        return is_float($value) ? round($value, 4) : 0;
    }

    public function hddTotal(): float
    {
        $value = (float)$this->request->input('hdd_total', 0);

        return is_float($value) ? round($value, 4) : 0;
    }

    public function ramUsed(): float
    {
        $value = (float)$this->request->input('ram_used', 0);

        return is_float($value) ? round($value, 4) : 0;
    }

    public function ramTotal(): float
    {
        $value = (float)$this->request->input('ram_total', 0);

        return is_float($value) ? round($value, 4) : 0;
    }

    public function serverScriptVersion(): string
    {
        return str_replace('v', '', $this->request->input('server_script_version', ''));
    }
}
