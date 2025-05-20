<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Services\UsuarioService;

class UsuarioController extends Controller
{
    public function index(): JsonResponse
    {
        $usuarios = (new UsuarioService())->list();
        return UsuarioResource::collection($usuarios);
    }

    public function show($id): JsonResponse
    {
        $usuario = (new UsuarioService())->find($usuario);
        return UsuarioResource::make($usuario);
    }

    public function store()
    {
        $validated = $request->validate([
            'nome' => ['required'],
            'email' => ['required', 'email', 'unique:usuario, email'],
            'senha'=> ['required', 'min:8'],
            'usuario_id' => ['integer'],
        ]);

        $usuario = (new UsuarioService())->create($validated, $usuario);

        return response()->json(['success' => 'Usuario criado com sucesso', 'editora' => $editora], 201);

    }

    public function update($id): JsonResponse
    {
        $validated = $request->validate([
            'nome' => ['required'],
            'email' => ['required', 'email', 'unique:usuario, email'],
            'senha'=> ['required', 'min:8'],
            'usuario_id' => ['integer'],
        ]);

        $usuario = (new UsuarioService())->update($validated, $usuario);

        return response()->json(['success' => 'Usuario alterado com sucesso', 'editora' => $editora], 201);

    }

    public function destroy(Usuario $usuario): JsonResponse
    {
        try {
            (new UsuarioService())->destroy($usuario);
            return response()->json([], 202);
        } catch (Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
