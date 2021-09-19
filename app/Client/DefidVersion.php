<?php

namespace App\Client;

use GuzzleHttp\Client;
use Str;

class DefidVersion extends BaseGithubVersionClient
{
    public function __construct()
    {
        parent::__construct(new Client([
            'base_uri' => config('client_uri.github.defid'),
        ]));
    }
    public function getCurrentVersion(): string
    {
        return cache()->remember('github.version.defid', now()->addHour(), function () {
            return Str::replace('v','',$this->loadLatestInfo()['tag_name'] ?? 'n/a');
        });
    }
}
