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
			'type'       => $this->type,
			'value'      => $this->getValue(),
		];
	}

    protected function floatValue(): float
    {
        return (float) $this->value;
	}

	protected function intValue(): float
    {
        return (int) $this->value;
	}

    protected function getValue()
    {
        if (in_array($this->type, ServerStatTypes::FLOAT_VALUE)) {
            return (float) $this->value;
        }
        if (in_array($this->type, ServerStatTypes::INT_VALUE)) {
            return (int) $this->value;
        }

        return $this->value;
	}
}
