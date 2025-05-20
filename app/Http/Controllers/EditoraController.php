<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EditoraService;
use App\Models\Editora;

class EditoraController extends Controller
{
    public function index(): JsonResponse
    {
        $editoras = (new EditoraService())->list();
        return EditoraResource::collection($editoras);
    }

    public function show(Editora $editora): JsonResponse
    {
        $editora = (new EditoraService())->find($editora);
        return EditoraResource::make($editora);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'min:3'],
            'descricao'=> ['string', 'nullable'],
        ]);

        $editora = (new EditoraService())->create($validated);

        return response()->json(['success' => 'Editora cadastrado com sucesso', 'editora' => $editora], 201);

    }

    public function update(Editora $editora): JsonResponse
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'min:3'],
            'descricao'=> ['string', 'nullable'],
        ]);

        $editora = (new EditoraService())->update($validated, $editora);

        return response()->json(['success' => 'Editora atualizada com sucesso', 'editora' => $editora], 201);
    }

    public function destroy(Editora $editora): JsonResponse
    {
        try {
            (new EditoraService())->destroy($editora);
            return response()->json([], 202);
        } catch (Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
