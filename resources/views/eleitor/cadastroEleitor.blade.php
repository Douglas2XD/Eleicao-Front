<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">Cadastro de Eleitor</h3>
                </div>
                <div class="card-body">
                    <form id="eleitorForm">
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
                                <div class="d-flex gap-2 justify-content-end">
                                    <button type="button" class="btn btn-secondary">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Salvar
                                        Eleitor</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/client.js') }}"></script>
<script>
    let vinculoCounter = 0;

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

    function adicionarVinculo() {
        vinculoCounter++;
        const container = document.getElementById('vinculosContainer');

        const vinculoDiv = document.createElement('div');
        vinculoDiv.className = 'card mb-3';
        vinculoDiv.id = `vinculo-${vinculoCounter}`;

        let cursosOptions = '<option value="">Selecione o curso</option>';
        cursosDisponiveis.forEach(curso => {
            cursosOptions += `<option value="${curso.id}">${curso.nome}</option>`;
        });

        vinculoDiv.innerHTML = `
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-bold">Vínculo #${vinculoCounter}</span>
        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removerVinculo(${vinculoCounter})">
            Remover
        </button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <label for="matricula-${vinculoCounter}" class="form-label">Matrícula <span
                        class="text-danger">*</span></label>
                <input type="text" class="form-control" id="matricula-${vinculoCounter}"
                    name="vinculos[${vinculoCounter}][matricula]" required>
            </div>
            <div class="col-md-4">
                <label for="tipo-${vinculoCounter}" class="form-label">Tipo de Vínculo <span
                        class="text-danger">*</span></label>
                <select class="form-select" id="tipo-${vinculoCounter}" name="vinculos[${vinculoCounter}][tipo]"
                    required>
                    <option value="">Selecione o tipo</option>
                    <option value="DISCENTE">Discente</option>
                    <option value="DOCENTE">Docente</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="curso-${vinculoCounter}" class="form-label">Curso <span
                        class="text-danger">*</span></label>
                <select class="form-select" id="curso-${vinculoCounter}" name="vinculos[${vinculoCounter}][curso_id]"
                    required>
                    ${cursosOptions}
                </select>
            </div>
        </div>
    </div>
    `;

        container.appendChild(vinculoDiv);
    }

    function removerVinculo(id) {
        const vinculo = document.getElementById(`vinculo-${id}`);
        if (vinculo) {
            vinculo.remove();
        }
        vinculoCounter--;
    }

    // Máscara para CPF
    document.getElementById('cpf').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 11) {
            value = value.substring(0, 11);
        }
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        e.target.value = value;
    });

    // Adicionar um vínculo por padrão
    document.addEventListener('DOMContentLoaded', function() {
        adicionarVinculo();
    });

    // Validação e submissão do formulário
    document.getElementById('eleitorForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Aqui você pode adicionar a lógica para enviar os dados para o backend
        const formData = new FormData(this);
        const data = {};

        // Processar dados básicos
        data.nome = formData.get('nome');
        data.email = formData.get('email');
        data.cpf = formData.get('cpf').replace(/\D/g, ''); // Remove formatação
        data.data_nascimento = formData.get('data_nascimento');
        data.status = formData.get('status');
        data.vinculos = [];
        pessoa = pegarPessoa(data.cpf)
        data.id = pessoa.id
        salvarEleitor(data);

        console.log('Dados do eleitor:', data);
        alert('Formulário validado com sucesso! Verifique o console para ver os dados.');
    });
</script>
