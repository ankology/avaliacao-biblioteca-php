<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class LivroController extends Controller
{
    public function list(): JsonResponse
    {
        return new JsonResponse([]);
    }
}
