<div class="container-fluid d-flex align-items-center justify-content-center">
    <div class="row justify-content-center w-100">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow">
                <div class="card-body p-5">
                    <!-- Logo/Título -->
                    <div class="text-center mb-4">
                        <h2 class="text-primary mb-2">Sistema Eleitoral</h2>
                        <p class="text-muted">Faça login com seu CPF</p>
                    </div>

                    <!-- Formulário de Login -->
                    <form id="loginForm">
                        <div class="mb-4">
                            <label for="cpf" class="form-label fw-bold">CPF</label>
                            <input type="text" class="form-control form-control-lg" id="cpf" name="cpf"
                                placeholder="000.000.000-00" required autofocus>
                            <div class="invalid-feedback">
                                Por favor, insira um CPF válido.
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Entrar
                            </button>
                        </div>
                    </form>

                    <!-- Links auxiliares -->
                    <div class="text-center mt-4">
                        <small class="text-muted">
                            Não consegue acessar?
                            <a href="#" class="text-decoration-none">Entre em contato</a>
                        </small>
                    </div>
                </div>
            </div>

            <!-- Informações adicionais -->
            <div class="text-center mt-3">
                <small class="text-muted">
                    © 2024 Sistema Eleitoral. Todos os direitos reservados.
                </small>
            </div>
        </div>
    </div>
</div>
<script>
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

    // Validação simples de CPF
    function validarCPF(cpf) {
        cpf = cpf.replace(/\D/g, '');

        if (cpf.length !== 11) return false;
        if (/^(\d)\1{10}$/.test(cpf)) return false; // CPFs com todos os dígitos iguais

        // Validação dos dígitos verificadores
        let soma = 0;
        for (let i = 0; i < 9; i++) {
            soma += parseInt(cpf.charAt(i)) * (10 - i);
        }
        let resto = 11 - (soma % 11);
        let dv1 = resto < 2 ? 0 : resto;

        if (dv1 !== parseInt(cpf.charAt(9))) return false;

        soma = 0;
        for (let i = 0; i < 10; i++) {
            soma += parseInt(cpf.charAt(i)) * (11 - i);
        }
        resto = 11 - (soma % 11);
        let dv2 = resto < 2 ? 0 : resto;

        return dv2 === parseInt(cpf.charAt(10));
    }

    // Submissão do formulário
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const cpfInput = document.getElementById('cpf');
        const cpf = cpfInput.value;

        // Remove classes de validação anteriores
        cpfInput.classList.remove('is-valid', 'is-invalid');

        // Validar CPF
        if (!validarCPF(cpf)) {
            cpfInput.classList.add('is-invalid');
            return;
        }

        cpfInput.classList.add('is-valid');

        // Preparar dados para envio
        const loginData = {
            cpf: cpf.replace(/\D/g, '') // Remove formatação para enviar apenas números
        };

        console.log('Dados de login:', loginData);

        // Aqui você faria a requisição para o backend
        // Simulação de loading
        const submitBtn = document.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Entrando...';

        // Simular resposta do servidor
        setTimeout(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
            alert('Login realizado com sucesso!\nCPF: ' + loginData.cpf);
            // window.location.href = '/dashboard'; // Redirecionar após login
        }, 1500);
    });

    // Permitir Enter para submeter
    document.getElementById('cpf').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('loginForm').dispatchEvent(new Event('submit'));
        }
    });
</script>
