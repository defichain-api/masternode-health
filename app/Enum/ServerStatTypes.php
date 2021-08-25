<?php

namespace App\Enum;

class ServerStatTypes
{
    const LOAD_AVG = 'load_avg';
    const RAM_USED = 'ram_used';
    const RAM_TOTAL = 'ram_total';
    const HDD_USED = 'hdd_used';
    const HDD_TOTAL = 'hdd_total';

    const NODE_UPTIME = 'node_uptime';
    const BLOCK_HEIGHT = 'block_height_local';
    const LOCAL_HASH = 'local_hash';
    const OPERATOR_STATUS = 'operator_status';
    const CONNECTIONCOUNT = 'connectioncount';
    const BLOCK_DIFF = 'block_diff';
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
        self::OPERATOR_STATUS,
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

    const ARRAY_VALUE = [
        self::OPERATOR_STATUS,
    ];
}
