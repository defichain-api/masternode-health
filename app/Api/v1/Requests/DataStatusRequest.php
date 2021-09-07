<?php

namespace App\Api\v1\Requests;

class DataStatusRequest extends ApiRequest
{
   public function rules(): array
    {
        return [
            'period' => ['sometimes', 'integer', 'min:5'],
        ];
    }
}
