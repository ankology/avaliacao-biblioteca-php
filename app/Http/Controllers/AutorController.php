<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Autor;
use App\Services\AutorService;

class AutorController extends Controller
{
    public function index(): JsonResponse
    {
        $autores = (new AutorService())->list();
        return AutorResource::collection($autores);
    }

    public function show(Autor $autor): JsonResponse
    {
        $autor = (new AutorService())->find($autor);
        return AutorResource::make($autor);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'min:3'],
            'data_nascimento' => ['nullable','date'],
            'biografia'=> ['string', 'nullable'],
        ]);

        $autor = (new AutorService())->create($validated);

        return response()->json(['success' => 'Autor cadastrado com sucesso', 'editora' => $editora], 201);

    }

    public function update(Autor $autor)
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'min:3'],
            'data_nascimento' => ['nullable','date'],
            'biografia'=> ['string', 'nullable'],
        ]);
        
        $autor = (new AutorService())->update($validated, $autor);

        return response()->json(['success' => 'Autor atualizada com sucesso', 'editora' => $editora], 201);
    }

    public function destroy(Autor $autor)
    {
        try {
            (new AutorService())->destroy($autor);
            return response()->json([], 202);
        } catch (Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
