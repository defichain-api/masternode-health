<?php

namespace App\Service;

use App\Models\ApiKey;

class ApiKeyService
{
    public function generateKey(): string
    {
        return ApiKey::create()->id;
    }
}
