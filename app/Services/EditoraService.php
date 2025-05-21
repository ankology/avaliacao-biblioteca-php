<?php

namespace App\Services;
use App\Models\Editora;

class EditoraService
{
    
    public function list(string $search)
    {
        return Editora::orderBy('nome')
                        ->where('nome','like', "%$search%")
                        ->paginate();
    }

    public function find(Editora $editora)
    {
        return Editora::find($editora);
    }

    public function create($request_validated)
    { 
        $editora = Editora::create([
            'nome' => $request_validated['nome'],
            'descricao' => $request_validated['descricao'] ?? '',
        ]);

        return $editora;
    }

    public function update($request_validated, Editora $editora)
    {   
        $editora->update([
            'nome' => $request_validated['nome'],
            'descricao' => $request_validated['descricao'] ?? '',
        ]);

        return $editora;
    }

    public function destroy(Editora $editora)
    {   
        return $editora->delete();
    }
}
