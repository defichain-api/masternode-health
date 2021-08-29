<?php

namespace App\Api\v1\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class NodeInfoRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'block_height_local' => ['required', 'integer'],
            'local_hash'         => ['required', 'string', 'min:64'],
            'node_uptime'        => ['required', 'integer'],
            'connection_count'   => ['sometimes', 'integer', 'min:0'],
            'logsize'            => ['sometimes', 'numeric'],
            'config_checksum'    => ['sometimes', 'string', 'min:32', 'max:32'],
            'operator_status'    => ['required', 'array'],
        ];
    }
}
