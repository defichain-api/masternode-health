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
            'block_height_local' => ['sometimes', 'integer'],
            'local_hash'         => ['sometimes', 'string', 'min:64'],
            'node_uptime'        => ['sometimes', 'integer'],
            'connection_count'   => ['sometimes', 'integer', 'min:0'],
            'logsize'            => ['sometimes', 'numeric'],
            'config_checksum'    => ['sometimes', 'string', 'min:32', 'max:32'],
            'node_version'       => ['sometimes', 'string'],
            'operator_status'    => ['sometimes', 'array'],
            'defid_running'      => ['sometimes', 'boolean'],
        ];
    }
}
