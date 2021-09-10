<?php

namespace App\Api\v1\RequestTransformer;

use App\Api\v1\Requests\NodeInfoRequest;
use App\Models\ApiKey;

class NodeInfoTransformer
{
    protected NodeInfoRequest $request;

    public function __construct(NodeInfoRequest $request)
    {
        $this->request = $request;
    }

    public function apiKey(): ApiKey
    {
        return $this->request->get('api_key');
    }

    public function connectioncount(): string
    {
        return $this->request->input('connection_count', '');
    }

    public function blockHeightLocal(): string
    {
        return $this->request->input('block_height_local', '');
    }

    public function operatorStatus(): string
    {
        return $this->request->has('operator_status') ? json_encode($this->request->input('operator_status')) : '';
    }

    public function localHash(): string
    {
        return $this->request->input('local_hash', '');
    }

    /**
     * uptime in seconds
     */
    public function nodeUptime(): int
    {
        return $this->request->input('node_uptime', 0);
    }

    public function nodeVersion(): string
    {
        return $this->request->input('node_version', '');
    }

    public function defidRunning(): bool
    {
        return $this->request->input('defid_running', true);
    }

    /**
     * logsize in MB
     */
    public function logsize(): float
    {
        return (float)$this->request->input('logsize', 0);
    }

    public function configChecksum(): string
    {
        return $this->request->input('config_checksum', '');
    }
}
