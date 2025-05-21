<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Services\UsuarioService;

class UsuarioController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $usuarios = (new UsuarioService())->list($request->get('search', ''));
        return response()->json($usuarios);
    }

    public function show(Usuario $usuario): JsonResponse
    {
        $usuario = (new UsuarioService())->find($usuario);
        return response()->json($usuario);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => ['required'],
            'email' => ['required', 'email'],
            'senha'=> ['required', 'min:8'],
        ]);

        $usuario = (new UsuarioService())->create($validated);

        return response()->json(['success' => 'Usuario criado com sucesso', 'usuario' => $usuario], 201);

    }

    public function update(Request $request, Usuario $usuario): JsonResponse
    {
        $validated = $request->validate([
            'nome' => ['required'],
            'email' => ['required', 'email'],
            'senha'=> ['required', 'min:8'],
            'usuario_id' => ['integer'],
        ]);

        $usuario = (new UsuarioService())->update($validated, $usuario);

        return response()->json(['success' => 'Usuario alterado com sucesso', 'usuario' => $usuario], 201);

    }

    public function destroy(Usuario $usuario): JsonResponse
    {
        try {
            (new UsuarioService())->destroy($usuario);
            return response()->json(['success'=>'usuario deletado com sucesso'], 202);
        } catch (Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
