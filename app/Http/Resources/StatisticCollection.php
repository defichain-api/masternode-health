<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Statistic */
class StatisticCollection extends ResourceCollection
{
	public function toArray($request): array
	{
		return [
			'data' => $this->collection,
		];
	}
}
