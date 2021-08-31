<?php

namespace App\Api\v1\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class ServerStatsRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'load_avg'  => ['required', 'numeric', 'min:0'],
            'num_cores' => ['required', 'integer', 'min:0'],
            'hdd_used'  => ['required', 'numeric', 'min:0'],
            'hdd_total' => ['required', 'numeric', 'min:0'],
            'ram_used'  => ['required', 'numeric', 'min:0'],
            'ram_total' => ['required', 'numeric', 'min:0'],
        ];
    }
}
