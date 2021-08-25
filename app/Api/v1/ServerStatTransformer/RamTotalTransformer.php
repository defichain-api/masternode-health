<?php

namespace App\Api\v1\ServerStatTransformer;

use App\Enum\ServerStatTypes;
use App\Models\ServerStat;

class RamTotalTransformer implements BaseTransformer
{
    protected ServerStat $value;

    public function __construct(ServerStat $value)
    {
        $this->value = $value;
    }

    public function getValue(): float
    {
        return (float)$this->value->value;
    }

    public function getValuePair(): array
    {
        return [
            'type'  => ServerStatTypes::RAM_TOTAL,
            'value' => $this->getValue(),
        ];
    }
}
