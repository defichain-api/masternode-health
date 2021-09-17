<?php

namespace App\Client;

use GuzzleHttp\Client;

class MnHealthScriptVersion extends BaseGithubVersionClient
{
    public function __construct()
    {
        parent::__construct(new Client([
            'base_uri' => 'https://api.github.com/repos/defichain-api/masternode-health-server/releases/latest',
        ]));
    }

    public function getCurrentVersion(): string
    {
        return cache()->remember('github.version.mn_health', now()->addHour(), function () {
            return $this->loadLatestInfo()['tag_name'] ?? 'n/a';
        });
    }
}
