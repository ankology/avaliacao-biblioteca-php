<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Autor extends Model
{
   
    protected $table = 'autor';

    protected $fillable = [
        'nome',
        'data_nascimento',
        'biografia',
    ];

    public function livros() : BelongsToMany
    {
        return $this->BelongsToMany(Livro::class, 'livro_autor', 'autor_id', 'livro_id');
    }
}
