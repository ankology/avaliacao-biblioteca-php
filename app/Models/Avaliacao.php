<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Avaliacao extends Model
{
    protected $fillable = [
        'nota',
        'descricao',
        'usuario_id',
        'livro_id',
    ];

    public function usuario() : BelongsTo
    {
        return $this->BelongsTo(Usuario::class);
    }

    public function livro() : BelongsTo
    {
        return $this->belongsTo(Livro::class);
    }
}
