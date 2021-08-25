<?php

namespace App\Api\v1\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class HomeController
{
    public function home(): JsonResponse
    {
        return response()->json([
            'api'  => route('api.ping'),
            'docs' => route('docs.index'),
        ], JsonResponse::HTTP_OK);
    }

    public function docs(): View
    {
        return view('scribe.index');
    }
}
