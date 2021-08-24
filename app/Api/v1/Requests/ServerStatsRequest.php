<?php

namespace App\Api\v1\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'validation failed',
            'errors'  => $validator->errors(),
        ], 422));
    }
}
