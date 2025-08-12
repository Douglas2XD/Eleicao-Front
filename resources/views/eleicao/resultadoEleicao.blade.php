@extends('template.template')

@section('content')

<div id="resultadoScreen" class="screen">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3><i class="fas fa-chart-bar me-2"></i>Resultado - Eleição Presidencial 2024</h3>
                <button class="btn btn-secondary" onclick="window.location.href='{{ url('/dashboard') }}';" style="cursor:pointer;">
                    <i class="fas fa-arrow-left me-2"></i>Voltar
                </button>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h5 class="text-muted">Total de Votos</h5>
                            <h2 class="text-primary">1,247</h2>
                        </div>
                    </div>
                </div> 
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h5 class="text-muted">Participação</h5>
                            <h2 class="text-success">87%</h2>
                        </div>
                    </div>
                </div>
            </div>

            <h5 class="mb-3">Resultado por Candidato:</h5>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <i class="fas fa-crown fa-2x text-warning mb-2"></i>
                            <h5 class="card-title">João Silva</h5>
                            <h3 class="text-success">45%</h3>
                            <p class="text-muted">561 votos</p>
                            <span class="badge bg-success">VENCEDOR</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="fas fa-user-circle fa-2x text-primary mb-2"></i>
                            <h5 class="card-title">Maria Santos</h5>
                            <h3 class="text-primary">32%</h3>
                            <p class="text-muted">399 votos</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="fas fa-user-circle fa-2x text-secondary mb-2"></i>
                            <h5 class="card-title">Pedro Oliveira</h5>
                            <h3 class="text-secondary">23%</h3>
                            <p class="text-muted">287 votos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection