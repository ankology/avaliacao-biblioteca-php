<?php

namespace App\Services;
use App\Models\Avaliacao;

class AvaliacaoService
{
    public function list(string $search)
    {
        try {
            return Avaliacao::orderBy('created_at', 'desc')
                ->where('usuario_id', $search)
                ->where('livro_id', $search)
                ->where('nota', $search)
                ->with('usuario')
                ->with('livro')
                ->paginate();

        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 422);
        }
    }


    public function find(Avaliacao $avaliacao)
    {
        return Avaliacao::find($avaliacao)
                            ->with('usuario')
                            ->with('livro');
    }

    public function create($request_validated)
    { 
        return Avaliacao::create([
            'usuario_id' => $request_validated['usuario_id'],
            'livro_id' => $request_validated['livro_id'],
            'nota' => $request_validated['nota'],
            'descricao' => $request_validated['descricao'] ?? '',
        ]);

    }

    public function update($request_validated, Avaliacao $avaliacao)
    {   
        $avaliacao->update([
            'usuario_id' => $request_validated['usuario_id'],
            'livro_id' => $request_validated['livro_id'],
            'nota' => $request_validated['nota'],
            'descricao' => $request_validated['descricao'] ?? '',
        ]);

        return $avaliacao;
    }

    public function destroy(Avaliacao $avaliacao)
    {   
        return $avaliacao->delete();
    }
}
