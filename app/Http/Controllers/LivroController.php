<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Services\LivroService;
use App\Models\Livro;

class LivroController extends Controller
{
    public function index(): JsonResponse
    {
        $livros = (new LivroService())->list();
        return LivroResource::collection($livros);
    }

    public function show(Livro $livro): JsonResponse
    {
        $livro = (new LivroService())->find($livro);
        return LivroResource::make($livro);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => ['required', 'string', 'min:3'],
            'data_publicacao'=> ['date', 'required'],
            'sinopse' => ['nullable', 'string'],
        ]);

        (new LivroService())->create($validated);

        return response()->json(['success' => 'Livro cadastrado com sucesso', 'livro' => $livro], 201);

    }

    public function update(Request $request, Livro $livro): JsonResponse
    {
        $validated = $request->validate([
            'titulo' => ['required', 'string', 'min:3'],
            'data_publicacao'=> ['date', 'required'],
            'sinopse' => ['nullable', 'string'],
        ]);

        (new LivroService())->update($validated, $livro);

        return response()->json(['success' => 'Livro atualizado com sucesso', 'livro' => $livro], 201);
    }

    public function destroy(Livro $livro): JsonResponse
    {
        try {
            (new LivroService())->destroy($livro);
            return response()->json([], 202);
        } catch (Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
