
@extends('template.template')
@section('content')
    <div id="menuScreen" class="screen">
        <div class="row">
            @if(session('eleitor'))
               <div class="col-md-3 mb-4" onclick="window.location.href='{{ route('criar.eleicao') }}';" style="cursor:pointer;">
                    <div class="card h-100 text-center" onclick="showScreen('criarEleicaoScreen')" style="cursor: pointer;">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <i class="fas fa-plus-circle fa-4x text-primary mb-3"></i>
                            <h5>Criar Eleição</h5>
                            <p class="text-muted">Cadastrar nova eleição</p>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-3 mb-4">
                <div class="card h-100 text-center" onclick="window.location.href='{{ route('ver.eleicoes') }}';" style="cursor:pointer;">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <i class="fas fa-list fa-4x text-success mb-3"></i>
                        <h5>Eleições</h5>
                        <p class="text-muted">Ver últimas eleições</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card h-100 text-center" onclick="window.location.href='{{route('ver.eleicao.ativa')}}'" style="cursor: pointer;">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <i class="fas fa-vote-yea fa-4x text-warning mb-3"></i>
                        <h5>Votar</h5>
                        <p class="text-muted">Participar de eleição</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card h-100 text-center" onclick="showScreen('resultadoScreen')" style="cursor: pointer;">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <i class="fas fa-chart-bar fa-4x text-info mb-3"></i>
                        <h5>Resultados</h5>
                        <p class="text-muted">Ver resultados</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
