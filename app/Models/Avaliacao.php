<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Avaliacao extends Model
{
    protected $table = 'avaliacao';
    
    protected $fillable = [
        'nota',
        'descricao',
        'usuario_id',
        'livro_id',
    ];

    public function usuario() : BelongsTo
    {
        return $this->BelongsTo(Usuario::class, 'usuario_id');
    }

    public function livro() : BelongsTo
    {
        return $this->BelongsTo(Livro::class);
    }
}
