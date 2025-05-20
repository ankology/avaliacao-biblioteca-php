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
        try {
            $livro = (new LivroService())->find($livro);
            return LivroResource::make($livro);
        } catch (Exception $exception) {
            return response()->json(['status' => false , 'message' =>'Livro não encontrado'], 404);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => ['required', 'string', 'min:3'],
            'data_publicacao'=> ['date', 'required'],
            'sinopse' => ['nullable', 'string'],
            'autores' => ['nullable', 'array:id']
        ]);

        try {
            $livro = (new LivroService())->create($validated);
            return response()->json(['success' => 'Livro cadastrado com sucesso', 'livro' => $livro], 201);
        }  catch (Exception $exception) {
            return response()->json(['error' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function update(Request $request, Livro $livro): JsonResponse
    {
        $validated = $request->validate([
            'titulo' => ['required', 'string', 'min:3'],
            'data_publicacao'=> ['date', 'required'],
            'sinopse' => ['nullable', 'string'],
            'autores' => ['nullable', 'array:id']
        ]);

        try {
            (new LivroService())->update($validated, $livro);
            return response()->json(['success' => 'Livro atualizado com sucesso', 'livro' => $livro], 201);
        } catch (Exception $exception) {
            return response()->json(['error' => false, 'message' => 'Falha ao alterar livro'], 422);
        }
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

    public function adicionarAutores(Livro $livro, array $autores)
    {
        try {
            (new LivroService())->adicionarAutores($livro, $autores);
            return response()->json(['success' => 'Autores adicionados com sucesso'], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => 'Falha ao inserir autores', 'message' => $exception->getMessage(), 422]);
        }
    }

    public function removerAutores(Livro $livro, array $autores)
    {
        try {
            (new LivroService())->removerAutores($livro, $autores);
            return response()->json(['success' => 'Autores removidos com sucesso'], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => 'Falha ao remover autores', 'message' => $exception->getMessage(), 422]);
        }
    }
}
