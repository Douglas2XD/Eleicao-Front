@extends('template.template')

@section('content')


<div id="criarEleicaoScreen" class="screen">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card">
        <div class="card-body p-4">
            <h3 class="mb-4">
                <i class="fas fa-plus-circle me-2"></i>Criar Nova Eleição
            </h3>
            <form id="criarEleicaoForm" method="POST" action="{{ route('salvar.eleicao') }}">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label">Título da Eleição <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ex: Eleição para Presidente" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label">Descrição <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3" placeholder="Descreva os detalhes da eleição" required></textarea>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Data de Início <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="data_start" name="data_start" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Data Final <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="data_final" name="data_final" required>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-6">
                        <button type="button" class="btn btn-secondary w-100" onclick="window.location.href='{{ url('/dashboard') }}';">
                            <i class="fas fa-arrow-left me-2"></i>Voltar
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-2"></i>Criar Eleição
                        </button>
                    </div>
                </div>
            </form>
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
