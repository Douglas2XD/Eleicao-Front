<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Auth;

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
        $id_eleicao = 'teste01eleicao';
        return view('eleicao.resultadoEleicao', compact('id_eleicao'));
    }

    public function verEleicaoAtiva(){
        return view('eleicao.verEleicaoAtiva');
    }

    public function registrarEleitor(Request $request)
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

            // --- montar data em DD-MM-YYYY (hífen) e camelCase key dataNascimento
            $dataNascimento = null;

            if ($request->filled('data_nascimento')) {
                // tenta dd/mm/YYYY primeiro (formulário BR)
                try {
                    $dataNascimento = Carbon::createFromFormat('d/m/Y', $request->data_nascimento)->format('d-m-Y');
                } catch (\Exception $e) {
                    try {
                        $dataNascimento = Carbon::parse($request->data_nascimento)->format('d-m-Y');
                    } catch (\Exception $e2) {
                        $dataNascimento = null;
                    }
                }
            }

            // se não veio no request, pega da pessoa retornada (campo vindo do serviço)
            if (empty($dataNascimento) && !empty($pessoa['dataNascimento'])) {
                try {
                    $dataNascimento = Carbon::parse($pessoa['dataNascimento'])->format('d-m-Y');
                } catch (\Exception $e) {
                    $dataNascimento = null;
                }
            }

            if (empty($dataNascimento)) {
                return back()->with('error', 'Data de nascimento inválida ou ausente.');
            }

            // garante capitalização "Ativo" caso usuário tenha enviado "ATIVO" ou "ativo"
            $status = $request->status ?? ($pessoa['status'] ?? 'Ativo');
            $status = ucfirst(strtolower((string) $status));

            // monta o payload com wrapper "eleitor" e camelCase
            $payload = [
                'eleitor' => [
                    'id' => (int) $pessoa['id'],
                    'nome' => $request->nome ?? $pessoa['nome'] ?? null,
                    'email' => $request->email ?? $pessoa['email'] ?? null,
                    'cpf' => $request->cpf ?? $pessoa['cpf'] ?? null,
                    'dataNascimento' => $dataNascimento,   // camelCase e DD-MM-YYYY
                    'status' => $status,                  // ex: "Ativo"
                    'vinculos' => []                      // ajuste se tiver vinculos reais
                ]
            ];

            Log::info('Payload para Node /enviar-eleitor: ' . json_encode($payload));

            $eleitorResponse = Http::timeout(30)->post('http://localhost:3000/enviar-eleitor', $payload);

            if ($eleitorResponse->successful()) {
                return back()->with('success', 'Eleitor cadastrado com sucesso!');
            } else {
                return back()->with('error', 'Erro ao cadastrar eleitor: ' . $eleitorResponse->body());
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Erro na comunicação: ' . $e->getMessage());
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
            'id' => "2",
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
