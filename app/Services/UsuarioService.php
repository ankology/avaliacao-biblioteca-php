<?php

namespace App\Services;
use App\Models\Usuario;

class UsuarioService
{
    public function list(array $params): Collection
    {
        try {
            return Usuario::all()->orderBy('nome')->paginate();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 422);
        }
    }

    public function find(Usuario $usuario)
    {
        return Usuario::find($usuario);
    }

    public function create($request_validated)
    { 
        return Usuario::create([
            'nome' => $request_validated->nome,
            'email' => $request_validated->email,
            'senha' => $request_validated->senha,
        ]);

    }

    public function update($request_validated, Usuario $usuario)
    {   
        $usuario->update([
            'nome' => $request_validated->nome,
            'email' => $request_validated->email,
            'senha' => $request_validated->senha,
        ]);

        return $usuario;
    }

    public function destroy(Usuario $usuario)
    {   
        return $usuario->delete();
    }
}
