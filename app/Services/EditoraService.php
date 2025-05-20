<?php

namespace App\Services;
use App\Models\Editora;

class EditoraService
{
    
    public function list(array $params): Collection
    {
        try {
            return Editora::all()->orderBy('nome')->paginate();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 422);
        }
    }

    public function find(Editora $editora)
    {
        return Editora::find($editora);
    }

    public function create($request_validated)
    { 
        return Editora::create([
            'nome' => $request_validated->nome,
            'descricao' => $request_validated->descricao ?? '',
        ]);

    }

    public function update($request_validated, Editora $editora)
    {   
        $editora->update([
           'nome' => $request_validated->nome,
            'descricao' => $request_validated->descricao ?? '',
        ]);

        return $editora;
    }

    public function destroy(Editora $editora)
    {   
        return $editora->delete();
    }
}
