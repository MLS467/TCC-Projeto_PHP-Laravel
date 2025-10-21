<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    body {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        color: #333;
        background-color: #f8f9fa;
        margin: 0;
        padding: 20px;
    }

    .container {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid #e9ecef;
    }

    .header {
        text-align: center;
        margin-bottom: 30px;
    }

    .lock-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        color: #6ba6ff;
    }

    .title {
        color: #2c3e50;
        font-size: 28px;
        margin: 0 0 10px 0;
        font-weight: bold;
    }

    .subtitle {
        color: #7f8c8d;
        font-size: 16px;
        margin: 0;
    }

    .info-section {
        background: #f0f9ff;
        border: 1px solid #bfdbfe;
        border-radius: 8px;
        padding: 20px;
        margin: 20px 0;
        font-size: 14px;
    }

    .info-section strong {
        color: #6ba6ff;
    }

    .reset-button {
        display: inline-block;
        background: linear-gradient(135deg, #6ba6ff 0%, #4a90e2 100%);
        color: white;
        padding: 15px 30px;
        text-decoration: none;
        border-radius: 10px;
        font-weight: bold;
        text-align: center;
        margin: 20px 0;
        box-shadow: 0 4px 15px rgba(107, 166, 255, 0.3);
        transition: all 0.3s ease;
    }

    /* Some email clients ignore :hover, but keep for web previews */
    .reset-button:hover {
        background: linear-gradient(135deg, #5a96ff 0%, #3b7dd8 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(107, 166, 255, 0.4);
    }

    .footer {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
        text-align: center;
        color: #666;
        font-size: 14px;
    }

    .security-note {
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        border-radius: 5px;
        padding: 15px;
        margin: 20px 0;
        font-size: 14px;
        color: #856404;
    }
    </style>
    <title>Redefinir Senha - AtendeBem</title>
</head>

<body>
    <div class="container">
        <!-- Header com ícone -->
        <div class="header">
            <div class="lock-icon">
                <svg fill="currentColor" viewBox="0 0 24 24" width="80" height="80">
                    <path
                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                    <!-- Linha de batimento cardíaco -->
                    <path stroke="white" stroke-width="1.5" fill="none" d="M6 12h2l1-3 2 6 2-3 1.5 1.5h3" />
                </svg>
            </div>
            <h1 class="title">AtendeBem</h1>
            <p class="subtitle">
                @if(isset($name) && $name !== 'Usuário')
                Olá, {{ $name }}! Recebemos uma solicitação para redefinir sua senha.
                @else
                Recebemos uma solicitação para redefinir sua senha.
                @endif
            </p>
        </div>

        <!-- Mensagem principal -->
        <div class="info-section">
            <p><strong>Solicitação de redefinição de senha</strong></p>
            <p>Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta.
            </p>

            @if(isset($token) && $token && isset($email) && $email)
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('show.reset.form', ['token' => $token, 'email' => $email]) }}"
                    class="reset-button">Redefinir Senha</a>
            </div>
            <p>Se você não conseguir clicar no botão acima, copie e cole o seguinte link em seu navegador:</p>
            <p style="word-break: break-all; color: #6ba6ff; font-size: 14px;">
                {{ route('show.reset.form', ['token' => $token, 'email' => $email]) }}
            </p>
            @endif
        </div>

        <!-- Nota de segurança -->
        <div class="security-note">
            <strong>⚠️ Importante:</strong>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Este link é válido por tempo limitado</li>
                <li>Se você não solicitou esta redefinição, ignore este e-mail</li>
                <li>Nunca compartilhe este link com outras pessoas</li>
            </ul>
        </div>

        <!-- Informações de contato/suporte -->
        <div class="footer">
            <p>Se você tem dúvidas ou precisa de ajuda, entre em contato com nosso suporte.</p>
            <p><strong>AtendeBem</strong> - Sistema de Atendimento Hospitalar</p>
        </div>
    </div>
</body>

</html>