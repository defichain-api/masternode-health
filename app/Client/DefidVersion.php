<?php

namespace App\Client;

use GuzzleHttp\Client;
use Str;

class DefidVersion extends BaseGithubVersionClient
{
    public function __construct()
    {
        parent::__construct(new Client([
            'base_uri' => 'https://api.github.com/repos/DeFiCh/ain/releases/latest',
        ]));
    }
    public function getCurrentVersion(): string
    {
        return cache()->remember('github.version.defid', now()->addHour(), function () {
            return Str::replace('v','',$this->loadLatestInfo()['tag_name'] ?? 'n/a');
        });
    }
}
