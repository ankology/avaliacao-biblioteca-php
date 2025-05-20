
<?php

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EditoraController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\AvaliacaoController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    return view('welcome');
});

Route::apiResource('usuarios', UsuarioController::class);

Route::apiResource('livros', LivroController::class);

Route::post('livros/{id}/autores', [LivroController::class, 'adicionarAutores']);

Route::delete('livros/{id}/autores', [LivroController::class, 'removerAutores']);

Route::apiResource('editoras', EditoraController::class);

Route::apiResource('autores', AutorController::class);

Route::apiResource('avaliacoes', AvaliacaoController::class);



