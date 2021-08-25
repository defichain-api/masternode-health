<?php

namespace App\Api\v1\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class ServerStatsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'load_avg'  => ['sometimes', 'numeric', 'min:0'],
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
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
