<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Models\Livro;

class LivroService
{
    public function list(array $params): Collection
    {
        try {
            return Livro::all()->orderBy('titulo')
                                ->with('autores')
                                ->with('editora')
                                ->paginate();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 422);
        }
    }

    public function find(Livro $livro)
    {
        return Livro::find($livro)->with('autores')->with('editora')->get();
    }

    public function create($request_validated)
    { 
        $livro = Livro::create([
            'editora_id' => $request_validated->editora_id,
            'titulo' => $request_validated->titulo,
            'data_publicacao' => $request_validated->data_publicacao,
            'sinopse' => $request_validated->sinopse ?? '',
        ]);

        if($request_validated->autores) {
            $livro->attach($request_validated->autores);
        }

        return $livro;
    }

    public function update($request_validated, Livro $livro)
    {   
        $livro->update([
            'editora_id' => $request_validated->editora_id,
            'titulo' => $request_validated->titulo,
            'data_publicacao' => $request_validated->data_publicacao,
            'sinopse' => $request_validated->sinopse ?? '',
        ]);

        if($request_validated->autores) {
            $livro->attach($request_validated->autores);
        }

        return $livro;
    }

    public function destroy(Livro $livro)
    {   
        return $livro->delete();
    }

    public function adicionarAutores(Livro $livro, array $autores) 
    {
        return $livro->autores()->attach($autores);
    }

    public function removerAutores(Livro $livro, array $autores) 
    {
        return $livro->autores()->detach($autores);
    }
}
