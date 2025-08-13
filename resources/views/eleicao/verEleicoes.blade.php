@extends('template.template')

@section('content')
<div id="eleicoesScreen" class="screen">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3><i class="fas fa-list me-2"></i>Últimas Eleições</h3>
                <button class="btn btn-secondary" onclick="window.location.href='{{ url('/dashboard') }}';" style="cursor:pointer;">
                    <i class="fas fa-arrow-left me-2"></i>Voltar
                </button>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Eleição Professores 2025</h5>
                            <p class="card-text text-muted">
                                <i class="fas fa-calendar me-2"></i>15/03/2025 - 20/03/2025<br>
                                <i class="fas fa-users me-2"></i>5 candidatos
                            </p>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary">Ver Detalhes</button>
                                <button class="btn btn-sm btn-primary" onclick="window.location.href='{{ route('ver.resultado', ['id' => 2]) }}';" style="cursor:pointer;">Ver Resultado</button>
                                @if(auth()->check() && auth()->user()->admin)
                                    <button class="btn btn-sm btn-outline-secondary">Modificar Eleição</button>
                                @endif 
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
