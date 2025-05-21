<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Autor;
use App\Services\AutorService;

class AutorController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $autores = (new AutorService())->list($request->get('search', ''));
        return response()->json($autores);
    }

    public function show(Autor $autore): JsonResponse
    {
        return response()->json($autore);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'min:3'],
            'data_nascimento' => ['nullable','date'],
            'biografia'=> ['string', 'nullable'],
        ]);

        $autor = (new AutorService())->create($validated);

        return response()->json(['success' => 'Autor cadastrado com sucesso', 'autor' => $autor], 201);

    }

    public function update(Request $request, Autor $autor)
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'min:3'],
            'data_nascimento' => ['nullable','date'],
            'biografia'=> ['string', 'nullable'],
        ]);
        
        $autor = (new AutorService())->update($validated, $autor);

        return response()->json(['success' => 'Autor atualizado com sucesso'], 201);
    }

    public function destroy(Autor $autore)
    {
        try {
            (new AutorService())->destroy($autore);
            return response()->json(['success'=> 'Autor deletado com sucesso'], 202);
        } catch (Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
