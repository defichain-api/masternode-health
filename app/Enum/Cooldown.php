<?php

namespace App\Enum;

/**
 * @docs https://github.com/Kurozora/laravel-cooldown
 */
class Cooldown
{
    const WEBHOOK_SERVER_STATS = 'webhook_server_stats';
    const WEBHOOK_NODE_INFO = 'webhook_node_info';

    const COOLDOWN_IN_HOURS = [
        self::WEBHOOK_SERVER_STATS => 12,
        self::WEBHOOK_NODE_INFO    => 3,
    ];
}
