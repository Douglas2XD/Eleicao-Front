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
                    <form id="loginForm" method="POST" action="{{ route('eleitor.autenticar') }}">
                        @csrf
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

