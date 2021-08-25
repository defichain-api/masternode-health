<?php

namespace App\Enum;

/**
 * @docs https://github.com/Kurozora/laravel-cooldown
 */
class Cooldown
{
    const WEBHOOK_SERVER_STATS = 'webhook_server_stats';
    const WEBHOOK_NODE_INFO = 'webhook_node_info';
    const LOCAL_SPLIT_NOTIFICATION = 'local_chain_split_notification';
    const REMOTE_SPLIT_NOTIFICATION = 'remote_chain_split_notification';
    const COOLDOWN_HOURS = [
        self::LOCAL_SPLIT_NOTIFICATION  => 2,
        self::REMOTE_SPLIT_NOTIFICATION => 2,
    ];
    const COOLDOWN_MIN = [
        self::WEBHOOK_SERVER_STATS => 5,
        self::WEBHOOK_NODE_INFO    => 5,
    ];
}
