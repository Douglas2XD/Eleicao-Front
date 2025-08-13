<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return view('welcome');
})->name('eleitor.registrar');

Route::post('/eleitor/registrar', [IndexController::class, 'registrarEleitor'])->name('eleitor.salvar');

Route::get('/eleitor/login', function() {
    return view('welcome');
})->name('eleitor.login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/ver-eleicoes', [IndexController::class, 'verEleicoes'])->name('ver.eleicoes');
Route::get('/ver-resultado', [IndexController::class, 'resultado'])->name('ver.resultado');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::get('/criar-eleicao', [IndexController::class, 'criarEleicao'])->name('criar.eleicao');

});
Route::get('/ver-eleicao-ativa', [IndexController::class, 'verEleicaoAtiva'])->name('ver.eleicao.ativa');
Route::get('/votacao', [IndexController::class, 'votar'])->name('votacao');

require __DIR__.'/auth.php';
