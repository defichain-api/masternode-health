<?php

namespace App\Api\v1\Requests;

class ApiHealthRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'period' => ['sometimes', 'integer', 'min:10'],
        ];
    }
}
