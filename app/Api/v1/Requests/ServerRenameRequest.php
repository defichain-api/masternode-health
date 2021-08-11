<?php

namespace App\Api\v1\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServerRenameRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
        ];
    }

    public function name(): string
    {
        return $this->input('name');
    }
}
