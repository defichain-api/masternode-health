<?php

namespace App\Helper;

use Illuminate\Support\Facades\Facade;
use Str;

class Version extends Facade
{
    public static function getVersionAsString(string $version): string
    {
        $step1 = Str::replace('v', '', $version);

        return Str::replace('-release', '', $step1);
    }

    public static function getVersionAsInt(string $version): int
    {
        // normalize the local version as it's output as e.g. 1.8.4.0, the remote one as 1.8.4
        $value = (int)Str::replace('.', '', self::getVersionAsString($version));

        return $value > 1000 ? $value / 1000 : $value;
    }
}
