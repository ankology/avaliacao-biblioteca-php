<?php

namespace App\Services;
use App\Models\Autor;

class AutorService
{
    public function list(string $search)
    {
        try {
            return Autor::orderBy('nome')
                        ->where('nome', 'like', "%$search%")
                        ->paginate();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 422);
        }
    }

    public function create($request_validated)
    { 
        return Autor::create([
            'nome' => $request_validated['nome'],
            'data_nascimento' => $request_validated['data_nascimento'],
            'biografia' => $request_validated['biografia'] ?? '',
        ]);

    }

    public function update($request_validated, Autor $autor)
    {   
        $autor->update([
            'nome' => $request_validated['nome'],
            'data_nascimento' => $request_validated['data_nascimento'],
            'biografia' => $request_validated['biografia'] ?? '',
        ]);

        return $autor;
    }

    public function destroy(Autor $autor)
    {   
        print_r($autor->delete());
    }
}
