<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Model
{
    protected $table = 'usuario';
    
    protected $fillable = [
        'nome',
        'email',
        'senha',
    ];

    public function avaliacoes() : HasMany
    {
        return $this->HasMany(Avaliacao::class);
    }
}
