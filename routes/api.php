
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
// Route::get('/usuarios', [UsuarioController::class, 'index']);
// Route::get('/usuarios/{id}', [UsuarioController::class, 'show']);
// Route::post('/usuarios', [UsuarioController::class, 'store']);
// Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);
// Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);

Route::apiResource('usuarios', UsuarioController::class);

Route::get('/livros', [LivroController::class, 'index']);
Route::get('/livros/{id}', [LivroController::class, 'show']);
Route::post('/livros', [LivroController::class, 'store']);
Route::put('/livros/{id}', [LivroController::class, 'update']);
Route::delete('/livros/{id}', [LivroController::class, 'destroy']);

Route::get('/editoras', [EditoraController::class, 'index']);
Route::get('/editoras/{id}', [EditoraController::class, 'show']);
Route::post('/editoras', [EditoraController::class, 'store']);
Route::put('/editoras/{id}', [EditoraController::class, 'update']);
Route::delete('/editoras/{id}', [EditoraController::class, 'destroy']);

Route::get('/autores', [AutorController::class, 'index']);
Route::get('/autores/{id}', [AutorController::class, 'show']);
Route::post('/autores', [AutorController::class, 'store']);
Route::put('/autores/{id}', [AutorController::class, 'update']);
Route::delete('/autores/{id}', [AutorController::class, 'destroy']);

Route::get('/avaliacoes', [AvaliacaoController::class, 'index']);
Route::get('/avaliacoes/{id}', [AvaliacaoController::class, 'show']);
Route::post('/avaliacoes', [AvaliacaoController::class, 'store']);
Route::put('/avaliacoes/{id}', [AvaliacaoController::class, 'update']);
Route::delete('/avaliacoes/{id}', [AvaliacaoController::class, 'destroy']);


