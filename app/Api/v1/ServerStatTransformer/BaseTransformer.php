<?php

namespace App\Api\v1\ServerStatTransformer;

use App\Models\ServerStat;

interface BaseTransformer
{
    public function __construct(ServerStat $serverStat);

    public function getValue();

    public function getValuePair(): array;
}
