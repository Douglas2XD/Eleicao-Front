@extends('template.template')
@section('content')
    <div id="loginScreen" class="screen active">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                    <i class="fas fa-user-circle fa-4x text-primary mb-3"></i>
                    <h3>Login</h3>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" name="email" class="form-control" placeholder="email@example.com" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" name="password" class="form-control" placeholder="********" required>
                        @error('password')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">
                        <i class="fas fa-sign-in-alt me-2"></i>Entrar
                    </button>

                    <div class="text-center">
                        <a href="#" onclick="showScreen('cadastroScreen')" class="text-decoration-none">
                        Não tem conta? Cadastre-se aqui
                        </a>
                    </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection