<?php

namespace App\Api\v1\Resources;

use App\Enum\ServerStatTypes;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\ServerStat */
class ServerStatResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'type'  => $this->type,
            'value' => $this->getValue(),
        ];
    }

    protected function floatValue(): float
    {
        return (float)$this->value;
    }

    protected function intValue(): float
    {
        return (int)$this->value;
    }

    protected function arrayValue(): array
    {
        return json_decode($this->value);
    }

    protected function boolValue(): bool
    {
        return (bool)$this->value;
    }

    protected function getValue()
    {
        if (in_array($this->type, ServerStatTypes::FLOAT_VALUE)) {
            return $this->floatValue();
        }
        if (in_array($this->type, ServerStatTypes::INT_VALUE)) {
            return $this->intValue();
        }
        if (in_array($this->type, ServerStatTypes::ARRAY_VALUE)) {
            return $this->arrayValue();
        }
        if (in_array($this->type, ServerStatTypes::BOOL_VALUE)) {
            return $this->boolValue();
        }

        return $this->value;
    }
}
