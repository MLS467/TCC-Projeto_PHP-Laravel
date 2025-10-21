<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha - AtendeBem</title>
    <link rel="stylesheet" href="{{ asset('css/reset-password.css') }}">
</head>

<body>
    <div class="container">
        <!-- Header com ícone -->
        <div class="header">
            <div class="lock-icon">
                <svg fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zM15.1 8H8.9V6c0-1.71 1.39-3.1 3.1-3.1s3.1 1.39 3.1 3.1v2z" />
                </svg>
            </div>
            <h1 class="title">Redefinir Senha</h1>
            <p class="subtitle">
                Digite sua nova senha nos campos abaixo
            </p>
        </div>

        <!-- Mensagens de erro -->
        @if ($errors->any())
        <div class="error-message">
            <svg fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
            </svg>
            <div>
                @foreach ($errors->all() as $error)
                {{ $error }}<br>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Mensagem de sucesso -->
        @if (session('status'))
        <div class="success-message">
            <svg fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            {{ session('status') }}
        </div>
        @endif

        <!-- Mensagens de Sucesso -->
        @if(session('success'))
        <div class="success-message">
            <svg fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
        @endif

        <!-- Mensagens de Erro -->
        @if($errors->any())
        <div class="error-message">
            <svg fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
            </svg>
            <div>
                @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Requisitos da senha -->
        <div class="password-requirements">
            <strong>Sua nova senha deve ter:</strong>
            <ul>
                <li>Pelo menos 8 caracteres</li>
                <li>Confirmação da senha deve ser igual</li>
            </ul>
        </div>

        <!-- Formulário -->
        <form method="POST" action="{{ route('reset.password') }}">
            @csrf

            <input type="hidden" name="token" value="{{ request('token') ?? session('token') ?? old('token') }}">
            <input type="hidden" name="email" value="{{ request('email') ?? session('email') ?? old('email') }}">

            <!-- Campo Nova Senha -->
            <div class="form-group">
                <label for="password" class="label">Nova Senha</label>
                <input id="password" type="password" name="password" class="input @error('password') error @enderror"
                    placeholder="Digite sua nova senha" required autocomplete="new-password" minlength="8">
            </div>

            <!-- Campo Confirmar Senha -->
            <div class="form-group">
                <label for="password_confirmation" class="label">Confirmar Nova Senha</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="input"
                    placeholder="Digite sua senha novamente" required autocomplete="new-password" minlength="8">
            </div>

            <!-- Botão Submit -->
            <button type="submit" class="btn-primary">
                Redefinir Senha
            </button>
        </form>

        <!-- Link de volta -->
        <div class="back-link">
            <a href="{{ url(env('FRONT_END_URL').'/forgot-password') }}">← Voltar para o início</a>
        </div>
    </div>

    <script>
    // Validação em tempo real
    document.addEventListener('DOMContentLoaded', function() {
        const password = document.getElementById('password');
        const passwordConfirmation = document.getElementById('password_confirmation');

        function validatePasswords() {
            if (password.value && passwordConfirmation.value) {
                if (password.value !== passwordConfirmation.value) {
                    passwordConfirmation.setCustomValidity('As senhas não coincidem');
                    passwordConfirmation.classList.add('error');
                } else {
                    passwordConfirmation.setCustomValidity('');
                    passwordConfirmation.classList.remove('error');
                }
            }
        }

        password.addEventListener('input', validatePasswords);
        passwordConfirmation.addEventListener('input', validatePasswords);

        // Mostrar/ocultar senha
        const showPasswordToggle = document.createElement('button');
        showPasswordToggle.type = 'button';
        showPasswordToggle.innerHTML = '👁️';
        showPasswordToggle.style.cssText = `
                position: absolute;
                right: 12px;
                top: 50%;
                transform: translateY(-50%);
                background: none;
                border: none;
                cursor: pointer;
                font-size: 16px;
            `;

        // Adicionar funcionalidade de mostrar senha (opcional)
        password.parentNode.style.position = 'relative';
    });
    </script>
</body>

</html>