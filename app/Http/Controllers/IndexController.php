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

    public function verEleicaoAtiva(){
        return view('eleicao.eleicaoAtiva');
    }

    public function registrarEleitor(Request $request){
        $cpfJson = json_encode($request->cpf);
        $request->id = shell_exec("node /public/js/buscar-id-por-cpf.js '" . escapeshellarg($cpfJson) . "'");

        $eleitorJson = json_encode($request->all());
        // Chama o script Node.js passando os dados do eleitor
        $output = shell_exec("node /public/js/client.js '" . escapeshellarg($eleitorJson) . "'");

        return response()->json([
            'message' => 'Eleitor salvo',
            'grpc_response' => $output,
        ]);
    }

    public function votar(){
        $eleicao = [
            'id' => "teste01eleicao",
            'candidatos' => [
                [
                    'id' => "candidato1",
                    'nome' => "Candidato 1",
                    'numero' => 1,
                ],
                [
                    'id' => "candidato2",
                    'nome' => "Candidato 2",
                    'numero' => 2,
                ],
                [
                    'id' => "candidato3",
                    'nome' => "Candidato 3",
                    'numero' => 3,
                ],
            ],
            'ativa' => true
        ];
        return view('eleicao.votar', compact('eleicao'));
    }
}
