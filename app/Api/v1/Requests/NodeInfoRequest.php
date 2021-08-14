<?php

namespace App\Api\v1\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NodeInfoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'connectioncount'       => ['required', 'integer', 'min:0'],
            'block_diff'            => ['required', 'integer'],
            'block_height_local'    => ['required', 'integer'],
            'main_net_block_height' => ['required', 'integer'],
            'local_hash'            => ['required', 'string', 'min:64'],
            'main_net_block_hash'   => ['required', 'string', 'min:64'],
            'local_split_found'     => ['required', 'boolean'],
            'logsize'               => ['required', 'integer'],
            'node_uptime'           => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
