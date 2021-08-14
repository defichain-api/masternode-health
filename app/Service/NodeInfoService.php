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
        $serverId = $transformer->server()->id;
        $data = collect([
            [
                'server_id' => $serverId,
                'type'      => ServerStatTypes::CONNECTIONCOUNT,
                'value'     => $transformer->connectioncount(),
            ],
            [
                'server_id' => $serverId,
                'type'      => ServerStatTypes::BLOCK_DIFF,
                'value'     => $transformer->blockDiff(),
            ],
            [
                'server_id' => $serverId,
                'type'      => ServerStatTypes::NODE_UPTIME,
                'value'     => $transformer->nodeUptime(),
            ],
            [
                'server_id' => $serverId,
                'type'      => ServerStatTypes::BLOCK_HEIGHT,
                'value'     => $transformer->blockHeightLocal(),
            ],
            [
                'server_id' => $serverId,
                'type'      => ServerStatTypes::LOCAL_HASH,
                'value'     => $transformer->localHash(),
            ],
            [
                'server_id' => $serverId,
                'type'      => ServerStatTypes::LOGSIZE,
                'value'     => $transformer->logsize(),
            ],
        ]);
        $data->each(function (array $item) {
            ServerStat::create([
                'server_id' => $item['server_id'],
                'type'      => $item['type'],
                'value'     => $item['value'],
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
