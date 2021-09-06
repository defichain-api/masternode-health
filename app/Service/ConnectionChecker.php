<?php

namespace App\Service;

use DB;
use Illuminate\Support\Facades\Redis;

class ConnectionChecker
{
    public static function isDatabaseReady($connection = null)
    {
        $isReady = true;
        try {
            DB::connection($connection)->getPdo();
        } catch (\Exception $e) {
            $isReady = false;
        }

        return $isReady;
    }

    public static function isRedisReady($connection = 'default')
    {
        try {
            return Redis::ping();
        } catch (\Exception $e) {
            return false;
        }
    }
}
