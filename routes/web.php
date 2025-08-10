<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/ver-eleicoes', [IndexController::class, 'verEleicoes'])->name('ver.eleicoes');
Route::get('/ver-resultado', [IndexController::class, 'resultado'])->name('ver.resultado');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::get('/criar-eleicao', [IndexController::class, 'criarEleicao'])->name('criar.eleicao');
    
});

require __DIR__.'/auth.php';
