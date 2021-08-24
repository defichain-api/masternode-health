<?php

namespace App\Service;

use App\Api\v1\Transformer\NodeInfoTransformer;
use App\Enum\ServerStatTypes;
use App\Api\v1\Requests\NodeInfoRequest;
use App\Models\ServerStat;

class NodeInfoService
{
    public function store(NodeInfoRequest $request): void
    {
        $transformer = new NodeInfoTransformer($request);
        $apiKeyId = $transformer->apiKey()->id;
        $data = collect([
            [
                'api_key_id' => $apiKeyId,
                'type'       => ServerStatTypes::CONNECTIONCOUNT,
                'value'      => $transformer->connectioncount(),
            ],
            [
                'api_key_id' => $apiKeyId,
                'type'       => ServerStatTypes::BLOCK_DIFF,
                'value'      => $transformer->blockDiff(),
            ],
            [
                'api_key_id' => $apiKeyId,
                'type'       => ServerStatTypes::NODE_UPTIME,
                'value'      => $transformer->nodeUptime(),
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
                'type'       => ServerStatTypes::LOGSIZE,
                'value'      => $transformer->logsize(),
            ],
        ]);
        $data->each(function (array $item) {
            ServerStat::create([
                'api_key_id' => $item['api_key_id'],
                'type'       => $item['type'],
                'value'      => $item['value'],
            ]);
        });
    }

    public function sendLocalSplitNotification(NodeInfoRequest $request): void
    {
//        $conversation = new LocalChainSplitConversation($request);
//
//        app(TelegramMessageService::class)->startConversation($request->getServer()->user, $conversation);
    }

    public function sendRemoteSplitNotification(NodeInfoRequest $request): void
    {
//        $conversation = new RemoteChainSplitConversation($request);
//
//        app(TelegramMessageService::class)->startConversation($request->getServer()->user, $conversation);
    }
}