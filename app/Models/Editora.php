<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Editora extends Model
{
    protected $fillable = [
        'nome',
        'descricao',
    ];

    public function livros() : HasMany
    {
        return $this->HasMany(Livro::class);
    }
}
