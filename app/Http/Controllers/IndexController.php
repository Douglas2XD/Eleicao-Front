<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;

class IndexController extends Controller
{
    public function criarEleicao(){
        return view('eleicao.criarEleicao');
    }

    public function salvarEleicao(Request $request){
        try {
            $response = Http::timeout(30)->post('http://localhost:3000/criar-eleicao', [
                'titulo' => $request->titulo,
                'descricao' => $request->descricao,
                'data_start' => $request->data_start,
                'data_final' => $request->data_final
            ]);

            if (!$response->successful()) {
                return back()->with('error', 'Erro ao criar eleição: ' . $response->body());
            }

            return back()->with('success', 'Eleição criada com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao criar eleição: ' . $e->getMessage());
        }
    }

    public function verEleicoes(){
        return view('eleicao.verEleicoes');
    }

    public function resultado(){
        $url = 'http://127.0.0.1:8081/eleicao/ver-resultado/2';

        $response = Http::get($url);
        if ($response->successful()) {
            $dados = $response->json();
            return view('eleicao.resultadoEleicao', compact('dados'));
        }

        # return view('eleicao.resultadoEleicao',compact('response'));
    }

    public function verEleicaoAtiva(){
        return view('eleicao.verEleicaoAtiva');
    }
    
    public function registrarEleitor(Request $request){
        // 1 - Buscar pessoa por CPF no Node/gRPC
        $response = Http::get('http://localhost:3000/buscar-pessoa-por-cpf', [
            'cpf' => $request->cpf
        ]);

        if (!$response->successful()) {
            return back()->with('error', 'Erro ao buscar pessoa pelo CPF');
        }

        $pessoa = $response->json();
        if (!isset($pessoa['id'])) {
            return back()->with('error', 'Pessoa não encontrada');
        }

        // 2 - Adicionar ID ao request e enviar eleitor
        $dadosEleitor = $request->all();
        $dadosEleitor['id'] = $pessoa['id'];

        $eleitorResponse = Http::post('http://localhost:3000/enviar-eleitor', $dadosEleitor);

        if ($eleitorResponse->successful()) {
            return back()->with('success', 'Eleitor cadastrado com sucesso!');
        } else {
            return back()->with('error', 'Erro ao enviar eleitor para o serviço Node.js');
        }
    }

    public function autenticarEleitor(Request $request)
    {
        try {
            $response = Http::timeout(30)->get('http://localhost:3000/buscar-pessoa-por-cpf', [
                'cpf' => $request->cpf
            ]);

            if (!$response->successful()) {
                return back()->with('error', 'Erro ao buscar pessoa: ' . $response->body());
            }

            $pessoa = $response->json()['pessoa'] ?? null;
            if (!$pessoa) {
                return back()->with('error', 'Pessoa não encontrada no serviço.');
            }

            // Armazena na sessão
            session(['eleitor' => $pessoa]);

            // Regenera o ID da sessão por segurança
            $request->session()->regenerate();

            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro na comunicação: ' . $e->getMessage());
        }
    }

    public function logoutEleitor() {
        session()->flush();
        return redirect()->route('eleitor.registrar');
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
        return view('eleicao.votacao', compact('eleicao'));
    }
}
