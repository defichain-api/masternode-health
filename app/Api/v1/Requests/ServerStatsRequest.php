<?php

namespace App\Api\v1\Requests;

use App\Models\Server;
use Illuminate\Foundation\Http\FormRequest;
use Str;

class ServerStatsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'cpu'       => ['sometimes', 'numeric', 'min:0'],
            'hdd_used'  => ['sometimes', 'numeric', 'min:0'],
            'hdd_total' => ['sometimes', 'numeric', 'min:0'],
            'ram_used'  => ['sometimes', 'numeric', 'min:0'],
            'ram_total' => ['sometimes', 'numeric', 'min:0'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
