<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class IndexController extends Controller
{
    public function criarEleicao(){
        Gate::authorize('criar-eleicao');
        return view('eleicao.criarEleicao');
    }

    public function verEleicoes(){
        return view('eleicao.verEleicoes');
    }

    public function resultado(){
        return view('eleicao.resultadoEleicao');
    }
}
