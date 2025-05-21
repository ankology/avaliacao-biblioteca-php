<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Livro extends Model
{
    protected $table = 'livro';
    protected $fillable = [
        'titulo',
        'data_publicacao',
        'sinopse',
        'editora_id',
    ];

    public function editora(): BelongsTo
    {
        return $this->belongsTo(Editora::class, 'editora_id');
    }

    public function autores(): BelongsToMany
    {
        return $this->belongsToMany(Autor::class, 'livro_autor', 'livro_id', 'autor_id');
    }
}