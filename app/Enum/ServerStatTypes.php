<?php

namespace App\Enum;

class ServerStatTypes
{
    const LOAD_AVG = 'load_avg';
    const RAM_USED = 'ram_used';
    const RAM_TOTAL = 'ram_total';
    const HDD_USED = 'hdd_used';
    const HDD_TOTAL = 'hdd_total';
    const CONNECTIONCOUNT = 'connectioncount';
    const NODE_UPTIME = 'node_uptime';
    const BLOCK_HEIGHT = 'block_height_local';
    const BLOCK_DIFF = 'block_diff';
    const LOCAL_HASH = 'local_hash';
    const LOGSIZE = 'logsize';

    const SERVER_STATS = [
        self::LOAD_AVG,
        self::RAM_USED,
        self::RAM_TOTAL,
        self::HDD_USED,
        self::HDD_TOTAL,
    ];

    const NODE_INFO = [
        self::NODE_UPTIME,
        self::BLOCK_HEIGHT,
        self::LOCAL_HASH,
    ];

    const FLOAT_VALUE = [
        self::LOAD_AVG,
        self::RAM_USED,
        self::RAM_TOTAL,
        self::HDD_USED,
        self::HDD_TOTAL,
    ];

    const INT_VALUE = [
        self::NODE_UPTIME,
        self::BLOCK_HEIGHT,
    ];
}
