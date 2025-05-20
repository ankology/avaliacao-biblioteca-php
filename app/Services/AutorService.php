<?php

namespace App\Services;
use App\Models\Autor;

class AutorService
{
    public function list(array $params): Collection
    {
        try {
            return Autor::all()->orderBy('nome')->paginate();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 422);
        }
    }

    public function find(Autor $autor)
    {
        return Autor::find($autor);
    }

    public function create($request_validated)
    { 
        return Autor::create([
            'nome' => $request_validated->nome,
            'data_nascimento' => $request_validated->data_nascimento,
            'biografia' => $request_validated->biografia ?? '',
        ]);

    }

    public function update($request_validated, Autor $autor)
    {   
        $autor->update([
            'nome' => $request_validated->nome,
            'data_nascimento' => $request_validated->data_nascimento,
            'biografia' => $request_validated->biografia ?? '',
        ]);

        return $autor;
    }

    public function destroy(Autor $autor)
    {   
        return $autor->delete();
    }
}
