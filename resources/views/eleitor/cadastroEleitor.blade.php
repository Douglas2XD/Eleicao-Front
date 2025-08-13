<div class="container my-5">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">Cadastro de Eleitor</h3>
                </div>
                <div class="card-body">
                    <form id="eleitorForm" method="POST" action="{{ route('eleitor.salvar') }}">
                        @csrf
                        <!-- Dados Pessoais -->
                        <h5 class="text-primary mb-3">Dados Pessoais</h5>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nome" class="form-label">Nome Completo <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>
                            <div class="col-md-6">
                                <label for="cpf" class="form-label">CPF <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="cpf" name="cpf"
                                    placeholder="000.000.000-00" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">E-mail <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="col-md-6">
                                <label for="data_nascimento" class="form-label">Data de Nascimento <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento"
                                    required>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="">Selecione o status</option>
                                    <option value="ATIVO">Ativo</option>
                                    <option value="INATIVO">Inativo</option>
                                    <option value="SUSPENSO">Suspenso</option>
                                </select>
                            </div>
                        </div>

                        <!-- Botões -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex gap-2 justify-content-between">
                                    <a href="{{ route('eleitor.login') }}">Já possui um cadastro? Entrar</a>
                                    <div>
                                        <button type="button" class="btn btn-secondary">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Salvar
                                            Eleitor</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Simulação de cursos cadastrados (em um caso real, isso viria de uma API)
    const cursosDisponiveis = [{
            id: 1,
            nome: "Engenharia de Software"
        },
        {
            id: 2,
            nome: "Ciência da Computação"
        },
        {
            id: 3,
            nome: "Sistemas de Informação"
        },
        {
            id: 4,
            nome: "Análise e Desenvolvimento de Sistemas"
        },
        {
            id: 5,
            nome: "Redes de Computadores"
        }
    ];
</script>
