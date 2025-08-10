@extends('template.template')

@section('content')


<div id="criarEleicaoScreen" class="screen">
    <div class="card">
        <div class="card-body p-4">
            <h3 class="mb-4">
                <i class="fas fa-plus-circle me-2"></i>Criar Nova Eleição
            </h3>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Nome da Eleição</label>
                    <input type="text" class="form-control" placeholder="Ex: Eleição para Presidente">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Data de Início</label>
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Data de Fim</label>
                    <input type="date" class="form-control">
                </div>
            </div>

            <h5 class="mb-3">Candidatos (máximo 10)</h5>
            <div id="candidatos">
                <div class="row mb-2">
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Nome do candidato">
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" placeholder="Número">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-outline-success w-100" onclick="addCandidato()">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-6">
                    <button type="button" class="btn btn-secondary w-100" onclick="window.location.href='{{ url('/dashboard') }}';" style="cursor:pointer;">
                        <i class="fas fa-arrow-left me-2"></i>Voltar
                    </button>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i>Criar Eleição
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let candidateCount = 1;
    function addCandidato() {
    if (candidateCount >= 10) {
        alert('Máximo de 10 candidatos permitido!');
        return;
    }

    candidateCount++;
    const candidatosDiv = document.getElementById('candidatos');
    const newRow = document.createElement('div');
    newRow.className = 'row mb-2';
    newRow.innerHTML = `
        <div class="col-md-4">
            <input type="text" class="form-control" placeholder="Nome do candidato">
        </div>
        <div class="col-md-2">
            <input type="number" class="form-control" placeholder="Número">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-outline-danger w-100" onclick="removeCandidato(this)">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    candidatosDiv.appendChild(newRow);
}

function removeCandidato(button) {
    button.closest('.row').remove();
    candidateCount--;
}
</script>
    
@endsection