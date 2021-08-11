<?php

namespace App\Service;

use App\Enum\ServerStatTypes;
use App\Api\v1\Requests\BlockInfoRequest;
use App\Models\ServerStat;

class BlockInfoService
{
    public function store(BlockInfoRequest $request): void
    {
        $serverId = $request->getServer()->id;
        $data = collect([
            [
                'server_id' => $serverId,
                'type'      => ServerStatTypes::CONNECTIONCOUNT,
                'value'     => $request->connectioncount(),
            ],
            [
                'server_id' => $serverId,
                'type'      => ServerStatTypes::BLOCK_DIFF,
                'value'     => $request->blockDiff(),
            ],
            [
                'server_id' => $serverId,
                'type'      => ServerStatTypes::NODE_UPTIME,
                'value'     => $request->nodeUptime(),
            ],
            [
                'server_id' => $serverId,
                'type'      => ServerStatTypes::BLOCK_HEIGHT,
                'value'     => $request->blockHeightLocal(),
            ],
            [
                'server_id' => $serverId,
                'type'      => ServerStatTypes::LOCAL_HASH,
                'value'     => $request->localHash(),
            ],
            [
                'server_id' => $serverId,
                'type'      => ServerStatTypes::LOGSIZE,
                'value'     => $request->logsize(),
            ],
        ]);
        $data->each(function (array $item) {
            ServerStat::create([
                'server_id' => $item['server_id'],
                'type'      => $item['type'],
            ], $item);
        });
    }

    public function sendLocalSplitNotification(BlockInfoRequest $request): void
    {
//        $conversation = new LocalChainSplitConversation($request);
//
//        app(TelegramMessageService::class)->startConversation($request->getServer()->user, $conversation);
    }

    public function sendRemoteSplitNotification(BlockInfoRequest $request): void
    {
//        $conversation = new RemoteChainSplitConversation($request);
//
//        app(TelegramMessageService::class)->startConversation($request->getServer()->user, $conversation);
    }
}
