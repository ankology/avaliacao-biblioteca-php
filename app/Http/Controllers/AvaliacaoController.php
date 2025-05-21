<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Avaliacao;
use App\Services\AvaliacaoService;

class AvaliacaoController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $avaliacoes = (new AvaliacaoService())->list($request->get('search', ''));
        return response()->json($avaliacoes);
    }

    public function show(Avaliacao $avaliacao): JsonResponse
    {
        return response()->json((new AvaliacaoService())->find($avaliacao));
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

        return response()->json(['success' => 'Avaliacao salva com sucesso', 'avaliacao' => $avaliacao], 201);

    }

    public function update(Request $request, Avaliacao $avaliacao): JsonResponse
    {
        $validated = $request->validate([
            'nota' => ['required', 'digits_between:1,5'],
            'descricao' => ['nullable'],
            'livro_id'=> ['integer'],
            'usuario_id' => ['integer'],
        ]);
    
        (new AvaliacaoService())->update($validated, $avaliacao);

        return response()->json(['success' => 'Avaliacao alterada com sucesso'], 201);

    }

    public function destroy(Avaliacao $avaliacao): JsonResponse
    {
        try {
            (new AvaliacaoService())->destroy($avaliacao);
            return response()->json(['success' => 'Avaliação removida com sucesso'], 202);
        } catch (Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
