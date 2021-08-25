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
            'operator_status'    => ['sometimes', 'array'],
            //            'connectioncount'       => ['required', 'integer', 'min:0'],
            //            'block_diff'            => ['required', 'integer'],
            //            'main_net_block_height' => ['required', 'integer'],
            //            'main_net_block_hash'   => ['required', 'string', 'min:64'],
            //            'local_split_found'     => ['required', 'boolean'],
            //            'logsize'               => ['required', 'integer'],
        ];
    }
}
