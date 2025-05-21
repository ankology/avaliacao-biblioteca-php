<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\EditoraService;
use App\Models\Editora;

class EditoraController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $editoras = (new EditoraService())->list($request->get('search', ''));
        return response()->json($editoras);
        return EditoraResource::collection($editoras);
    }

    public function show(Editora $editora): JsonResponse
    {
        return response()->json([$editora]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'min:3'],
            'descricao'=> ['string', 'nullable'],
        ]);

        $editora = (new EditoraService())->create($validated);

        return response()->json(['success' => 'Editora cadastrada com sucesso', 'editora' => $editora], 201);

    }

    public function update(Request $request, Editora $editora): JsonResponse
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
            return response()->json(['success' => 'Editora removida com sucesso'], 200);
        } catch (Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
