<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Usuario extends Model
{
    protected $fillable = [
        'nome',
        'email',
        'senha',
    ];

    public function avaliacoes() : BelongsToMany
    {
        return $this->BelongsToMany(Avaliacao::class);
    }
}
