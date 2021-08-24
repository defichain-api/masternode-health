<?php

namespace App\Api\v1\Transformer;

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
        return $this->request->input('connectioncount');
    }

    public function blockDiff(): string
    {
        return $this->request->input('block_diff');
    }

    public function blockHeightLocal(): string
    {
        return $this->request->input('block_height_local');
    }

    public function mainNetBlockHeight(): string
    {
        return $this->request->input('main_net_block_height');
    }

    public function localHash(): string
    {
        return $this->request->input('local_hash');
    }

    public function mainNetBlockHash(): string
    {
        return $this->request->input('main_net_block_hash');
    }

    /**
     * uptime in seconds
     */
    public function nodeUptime(): int
    {
        return $this->request->input('node_uptime');
    }

    public function localSplitFound(): bool
    {
        return $this->request->input('local_split_found');
    }

    public function logsize(): string
    {
        return $this->request->input('logsize');
    }
}
