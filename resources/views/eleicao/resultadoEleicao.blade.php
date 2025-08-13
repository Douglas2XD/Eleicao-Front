@extends('template.template')

@section('content')

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
    }
    .progress {
        height: 30px;
        border-radius: 5px;
    }
    .badge-eleito {
        background-color: #00a650;
        color: white;
    }
    .foto-circular {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }
    .barra-votos {
        height: 10px;
        border-radius: 5px;
    }
</style>



<h1 class="text-center">Resultado Eleição</h1>

<ul class="nav nav-tabs mt-4">
    <li class="nav-item">
        <a class="nav-link active" href="#">Resultado</a>
    </li>
</ul>

<h4 class="mt-4">Candidatos</h4>

<div class="mb-4">
    @php
        $totalVotos = array_sum(array_column($dados['concorrentes'], 'total_votos'));
    @endphp

    @foreach($dados['concorrentes'] as $candidato)
        @php
            $percentual = ($candidato['total_votos'] / $totalVotos) * 100;
            $classeBarra = $candidato['id_candidato'] == $dados['vencedor']['id_candidato'] ? 'bg-success' : 'bg-secondary';
        @endphp

        <div class="media mb-3">
            <img src="https://cdn-icons-png.freepik.com/512/21/21294.png" class="foto-circular mr-3" alt="{{ $candidato['nome'] }}">
            <div class="media-body">
                <h5 class="mt-0">{{ $candidato['nome'] }}</h5>
                <p>Idade: {{ $candidato['idade'] }}
                    @if($candidato['id_candidato'] == $dados['vencedor']['id_candidato'])
                        <span class="badge badge-eleito">ELEITO</span>
                    @endif
                </p>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ number_format($percentual, 2) }}%</strong><br>
                        {{ $candidato['total_votos'] }} votos
                    </div>
                    <div class="barra-votos col-8">
                        <div class="progress">
                            <div class="progress-bar {{ $classeBarra }}" role="progressbar" style="width: {{ $percentual }}%;" aria-valuenow="{{ $percentual }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <br><br><br><br>
</div>



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


@endsection