<?php

namespace App\Service;

use App\Api\v1\RequestTransformer\NodeInfoTransformer;
use App\Enum\ServerStatTypes;
use App\Api\v1\Requests\NodeInfoRequest;
use App\Models\ServerStat;
use Illuminate\Support\Collection;

class NodeInfoService
{
    public function store(NodeInfoRequest $request): Collection
    {
        $transformer = new NodeInfoTransformer($request);
        $apiKeyId = $transformer->apiKey()->key();
        $data = collect([
            [
                'api_key_id' => $apiKeyId,
                'type'       => ServerStatTypes::CONNECTION_COUNT,
                'value'      => $transformer->connectioncount(),
            ],
            [
                'api_key_id' => $apiKeyId,
                'type'       => ServerStatTypes::NODE_UPTIME,
                'value'      => $transformer->nodeUptime(),
            ],
            [
                'api_key_id' => $apiKeyId,
                'type'       => ServerStatTypes::DEFID_RUNNING,
                'value'      => $transformer->defidRunning(),
            ],
            [
                'api_key_id' => $apiKeyId,
                'type'       => ServerStatTypes::NODE_VERSION,
                'value'      => $transformer->nodeVersion(),
            ],
            [
                'api_key_id' => $apiKeyId,
                'type'       => ServerStatTypes::BLOCK_HEIGHT,
                'value'      => $transformer->blockHeightLocal(),
            ],
            [
                'api_key_id' => $apiKeyId,
                'type'       => ServerStatTypes::LOCAL_HASH,
                'value'      => $transformer->localHash(),
            ],
            [
                'api_key_id' => $apiKeyId,
                'type'       => ServerStatTypes::OPERATOR_STATUS,
                'value'      => $transformer->operatorStatus(),
            ],
            [
                'api_key_id' => $apiKeyId,
                'type'       => ServerStatTypes::LOGSIZE,
                'value'      => $transformer->logsize(),
            ],
            [
                'api_key_id' => $apiKeyId,
                'type'       => ServerStatTypes::CONFIG_CHECKSUM,
                'value'      => $transformer->configChecksum(),
            ],
        ]);
        $addedNodeInfo = new Collection();

        $data->each(function (array $item) use (&$addedNodeInfo) {
            if (is_null($item['value']) || $item['value'] === '') {
                return;
            }
            $addedNodeInfo->add(
                ServerStat::create([
                    'api_key_id' => $item['api_key_id'],
                    'type'       => $item['type'],
                    'value'      => $item['value'],
                ])
            );
        });

        return $addedNodeInfo;
    }
}
