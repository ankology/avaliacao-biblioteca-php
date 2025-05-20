<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Models\Livro;

class LivroService
{
    public function list(array $params): Collection
    {
        try {
            return Livro::all()->orderBy('titulo')->paginate();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 422);
        }
    }

    public function find(Livro $livro)
    {
        return Livro::find($livro);
    }

    public function create($request_validated)
    { 
        return Livro::create([
            'editora_id' => $request_validated->editora_id,
            'titulo' => $request_validated->titulo,
            'data_publicacao' => $request_validated->data_publicacao,
            'sinopse' => $request_validated->sinopse ?? '',
        ]);

    }

    public function update($request_validated, Livro $livro)
    {   
        $livro->update([
            'editora_id' => $request_validated->editora_id,
            'titulo' => $request_validated->titulo,
            'data_publicacao' => $request_validated->data_publicacao,
            'sinopse' => $request_validated->sinopse ?? '',
        ]);

        return $livro;
    }

    public function destroy(Livro $livro)
    {   
        return $livro->delete();
    }
}
