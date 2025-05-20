<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Avaliacao;
use App\Services\AvaliacaoService;

class AvaliacaoController extends Controller
{
    public function index(): JsonResponse
    {
        $avaliacoes = (new AvaliacaoService())->list();
        return AvaliacaoResource::collection($autores);
    }

    public function show(): JsonResponse
    {
        $avaliacao = (new AvaliacaoService())->find($avaliacao);
        return AvaliacaoResource::make($avaliacao);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nota' => ['required', 'digits_between:1,5'],
            'descricao' => ['nullable'],
            'livro_id'=> ['integer'],
            'usuario_id' => ['integer'],
        ]);

        $avaliacao = (new AvaliacaoService())->create($validated);

        return response()->json(['success' => 'Avaliacao salva com sucesso', 'editora' => $editora], 201);

    }

    public function update(Request $request, Avaliacao $avaliacao): JsonResponse
    {
        $validated = $request->validate([
            'nota' => ['required', 'digits_between:1,5'],
            'descricao' => ['nullable'],
            'livro_id'=> ['integer'],
            'usuario_id' => ['integer'],
        ]);
    
        $avaliacao = (new AvaliacaoService())->update($validated, $avaliacao);

        return response()->json(['success' => 'Avaliacao alterada com sucesso', 'editora' => $editora], 201);

    }

    public function destroy(Avaliacao $avaliacao): JsonResponse
    {
        try {
            (new AvaliacaoService())->destroy($avaliacao);
            return response()->json([], 202);
        } catch (Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
