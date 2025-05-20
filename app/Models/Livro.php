<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Livro extends Model
{
    protected $fillable = [
        'editora_id',
        'titulo',
        'data_publicacao',
        'sinopse',
    ];

    public function editora(): BelongsTo
    {
        return $this->belongsTo(Editora::class);
    }

    public function autores(): BelongsToMany
    {
        return $this->BelongsToMany(Autor::class, 'livro_autor');
    }
}