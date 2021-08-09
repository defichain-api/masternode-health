<?php

namespace App\Api\v1\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class HomeController
{
    public function home(): JsonResponse
    {
        return response()->json([
            'api' => '',
            'docs' => '',
        ], JsonResponse::HTTP_OK);
    }

    public function docs(): View
    {
        return view('scribe.index');
    }
}
