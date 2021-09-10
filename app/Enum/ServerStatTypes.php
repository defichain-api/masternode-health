<?php

namespace App\Enum;

class ServerStatTypes
{
    const LOAD_AVG = 'load_avg';
    const NUM_CORES = 'num_cores';
    const RAM_USED = 'ram_used';
    const RAM_TOTAL = 'ram_total';
    const HDD_USED = 'hdd_used';
    const HDD_TOTAL = 'hdd_total';
    const SERVER_SCRIPT_VERSION = 'server_script_version';

    const NODE_UPTIME = 'node_uptime';
    const DEFID_RUNNING = 'defid_running';
    const NODE_VERSION = 'node_version';
    const BLOCK_HEIGHT = 'block_height_local';
    const LOCAL_HASH = 'local_hash';
    const OPERATOR_STATUS = 'operator_status';
    const CONNECTION_COUNT = 'connection_count';
    const LOGSIZE = 'logsize';
    const CONFIG_CHECKSUM = 'config_checksum';

    const SERVER_STATS = [
        self::LOAD_AVG,
        self::NUM_CORES,
        self::RAM_USED,
        self::RAM_TOTAL,
        self::HDD_USED,
        self::HDD_TOTAL,
        self::SERVER_SCRIPT_VERSION,
    ];

    const NODE_INFO = [
        self::NODE_UPTIME,
        self::DEFID_RUNNING,
        self::NODE_VERSION,
        self::BLOCK_HEIGHT,
        self::LOCAL_HASH,
        self::OPERATOR_STATUS,
        self::CONNECTION_COUNT,
        self::LOGSIZE,
        self::CONFIG_CHECKSUM,
    ];

    const FLOAT_VALUE = [
        self::LOAD_AVG,
        self::RAM_USED,
        self::RAM_TOTAL,
        self::HDD_USED,
        self::HDD_TOTAL,
        self::LOGSIZE,
    ];

    const INT_VALUE = [
        self::NUM_CORES,
        self::NODE_UPTIME,
        self::BLOCK_HEIGHT,
        self::CONNECTION_COUNT,
    ];

    const BOOL_VALUE = [
        self::DEFID_RUNNING,
    ];

    const ARRAY_VALUE = [
        self::OPERATOR_STATUS,
    ];
}
