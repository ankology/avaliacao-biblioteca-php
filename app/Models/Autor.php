<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Autor extends Model
{
    protected $primaryKey = 'autor_id';

    protected $fillable = [
        'nome',
        'data_nascimento',
        'biografia',
    ];

    public function livros()
    {
        return $this->HasMany(Livro::class);
    }
}
