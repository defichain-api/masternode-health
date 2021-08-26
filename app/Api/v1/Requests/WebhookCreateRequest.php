<?php

namespace App\Api\v1\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class WebhookCreateRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'url'                => ['required', 'active_url'],
            'max_tries'          => ['sometimes', 'numeric', 'min:1', 'max:10'],
            'timeout_in_seconds' => ['sometimes', 'numeric', 'min:1', 'max:5'],
            'reference'          => ['nullable', 'string'],
        ];
    }
}
