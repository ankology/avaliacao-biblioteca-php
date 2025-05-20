<?php

namespace App\Services;

class AvaliacaoService
{
    public function list(array $params): Collection
    {
        try {
            return Avaliacao::all()->orderBy('created_at')->paginate();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 422);
        }
    }


    public function find(Avaliacao $avaliacao)
    {
        return Avaliacao::find($avaliacao);
    }

    public function create($request_validated)
    { 
        return Avaliacao::create([
            'usuario_id' => $request_validated->usuario_id,
            'livro' => $request_validated->livro,
            'nota' => $request_validated->nota,
            'descricao' => $request_validated->descricao ?? '',
        ]);

    }

    public function update($request_validated, Avaliacao $avaliacao)
    {   
        $avaliacao->update([
            'usuario_id' => $request_validated->usuario_id,
            'livro' => $request_validated->livro,
            'nota' => $request_validated->nota,
            'descricao' => $request_validated->descricao ?? '',
        ]);

        return $avaliacao;
    }

    public function destroy(Avaliacao $avaliacao)
    {   
        return $avaliacao->delete();
    }
}
