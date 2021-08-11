<?php

namespace App\Api\v1\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServerKeyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'api_key' => ['required', 'uuid', 'exists:api_keys,id'],
            'name'    => ['string'],
        ];
    }

    public function apiKey(): string
    {
        return $this->input('api_key');
    }

    public function name(): ?string
    {
        return $this->input('name') ?? null;
    }
}
