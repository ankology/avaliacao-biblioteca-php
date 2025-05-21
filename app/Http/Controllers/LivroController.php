<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\LivroService;
use App\Models\Livro;

class LivroController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $livros = (new LivroService())->list($request->get('search', ''));
        return response()->json($livros);
    }

    public function show(Livro $livro): JsonResponse
    {
        try {
            return response()->json($livro);
        } catch (Exception $exception) {
            return response()->json(['status' => false , 'message' =>'Livro não encontrado'], 404);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => ['required', 'string', 'min:3'],
            'data_publicacao'=> ['date', 'required'],
            'editora_id' => ['required', 'integer'],
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
            'autores' => ['nullable', 'array:id'],
            'editora_id' => ['required', 'integer'],
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
            return response()->json(['success' => 'livro removido com sucesso'], 202);
        } catch (Exception $exception) {
            return response()->json(['status' => false, 'message' => 'não foi possível encontrar esse livro'], 422);
        }
    }

    public function adicionarAutores(Livro $livro, Request $request)
    {
        try {
            (new LivroService())->adicionarAutores($livro, $request->get('autores'));
            return response()->json(['success' => 'Autores adicionados com sucesso'], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => 'Falha ao inserir autores', 'message' => $exception->getMessage(), 422]);
        }
    }

    public function removerAutores(Livro $livro, Request $request)
    {
        try {
            (new LivroService())->removerAutores($livro, $request->get('autores'));
            return response()->json(['success' => 'Autores removidos com sucesso'], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => 'Falha ao remover autores', 'message' => $exception->getMessage(), 422]);
        }
    }
}
