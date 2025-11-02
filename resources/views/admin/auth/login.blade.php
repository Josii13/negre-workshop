@extends('admin.layouts.guest')

@section('title', 'Connexion')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .back-button {
        position: absolute;
        top: 20px;
        left: 20px;
        color: white;
        text-decoration: none;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: opacity 0.3s;
        z-index: 10;
    }

    .back-button:hover {
        opacity: 0.8;
        color: white;
    }

    .login-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        width: 100%;
        max-width: 420px;
        padding: 48px 40px;
        animation: slideUp 0.5s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-header {
        text-align: center;
        margin-bottom: 32px;
    }

    .login-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 8px;
    }

    .login-header p {
        color: #718096;
        font-size: 14px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: #2d3748;
        margin-bottom: 8px;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s;
        outline: none;
    }

    .form-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-input.is-invalid {
        border-color: #f56565;
    }

    .invalid-feedback {
        color: #f56565;
        font-size: 13px;
        margin-top: 6px;
        display: block;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 24px;
    }

    .checkbox-group input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .checkbox-group label {
        font-size: 14px;
        color: #4a5568;
        cursor: pointer;
        margin: 0;
    }

    .btn-login {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }

    .btn-login:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    }

    .btn-login:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .btn-text {
        display: inline-block;
        transition: opacity 0.3s;
    }

    .btn-login.loading .btn-text {
        opacity: 0;
    }

    .loader {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .btn-login.loading .loader {
        opacity: 1;
    }

    .spinner {
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .alert-success {
        background-color: #c6f6d5;
        border: 1px solid #9ae6b4;
        color: #22543d;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .login-footer {
        text-align: center;
        margin-top: 24px;
        padding-top: 24px;
        border-top: 1px solid #e2e8f0;
    }

    .login-footer small {
        color: #718096;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    @media (max-width: 576px) {
        .login-card {
            padding: 32px 24px;
        }

        .login-header h1 {
            font-size: 24px;
        }

        .back-button {
            position: relative;
            top: 0;
            left: 0;
            margin-bottom: 20px;
            color: white;
        }
    }
</style>

<a href="{{ url('/') }}" class="back-button">
    <i class="fas fa-arrow-left"></i> Retour au site
</a>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h1>Bienvenue !</h1>
            <p>Connectez-vous à votre compte</p>
        </div>

        @if (session('status'))
            <div class="alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Adresse email</label>
                <input type="email"
                       class="form-input @error('email') is-invalid @enderror"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autofocus
                       autocomplete="username"
                       placeholder="exemple@email.com">
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password"
                       class="form-input @error('password') is-invalid @enderror"
                       id="password"
                       name="password"
                       required
                       autocomplete="current-password"
                       placeholder="••••••••">
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="remember_me" name="remember">
                <label for="remember_me">Se souvenir de moi</label>
            </div>

            <button type="submit" class="btn-login" id="loginBtn">
                <span class="btn-text">Connexion</span>
                <div class="loader">
                    <div class="spinner"></div>
                </div>
            </button>
        </form>

        <div class="login-footer">
            <small>
                <i class="fas fa-info-circle"></i>
                Contactez un super administrateur pour obtenir vos identifiants
            </small>
        </div>
    </div>
</div>

<script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const btn = document.getElementById('loginBtn');
        btn.classList.add('loading');
        btn.disabled = true;
    });
</script>
@endsection
