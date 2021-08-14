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
            'cpu'       => ['required', 'string'],
            'hdd_used'  => ['required', 'string'],
            'hdd_total' => ['required', 'string'],
            'ram_used'  => ['required', 'string'],
            'ram_total' => ['required', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
