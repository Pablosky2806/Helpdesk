<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesion - {{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f0f2f5; min-height: 100vh; display: flex; align-items: center; justify-content: center; margin: 0; }
        .auth-wrapper { width: 100%; max-width: 960px; display: flex; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.12); min-height: 560px; }
        .auth-sidebar { width: 400px; background: linear-gradient(145deg, #1e3a5f 0%, #132744 100%); color: #fff; padding: 48px 40px; display: flex; flex-direction: column; justify-content: center; flex-shrink: 0; }
        .auth-sidebar h2 { font-size: 1.75rem; font-weight: 700; margin-bottom: 8px; }
        .auth-sidebar .subtitle { font-size: 0.9rem; color: rgba(255,255,255,0.6); line-height: 1.6; margin-bottom: 36px; }
        .feature-item { display: flex; align-items: center; gap: 14px; margin-bottom: 20px; }
        .feature-icon { width: 42px; height: 42px; background: rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .feature-icon i { font-size: 18px; color: rgba(255,255,255,0.8); }
        .feature-item span { font-size: 0.88rem; color: rgba(255,255,255,0.65); }
        .auth-form-area { flex: 1; background: #fff; padding: 48px 44px; display: flex; flex-direction: column; justify-content: center; }
        .auth-form-area h3 { font-size: 1.5rem; font-weight: 700; color: #1a1a2e; margin-bottom: 6px; }
        .auth-form-area .desc { font-size: 0.9rem; color: #6c757d; margin-bottom: 28px; }
        .form-label { font-size: 0.85rem; font-weight: 600; color: #344054; margin-bottom: 6px; }
        .form-control { border: 1.5px solid #e0e3e8; border-radius: 10px; padding: 11px 14px; font-size: 0.9rem; background: #f8f9fb; transition: border-color 0.2s, box-shadow 0.2s; }
        .form-control:focus { border-color: #4a90d9; box-shadow: 0 0 0 3px rgba(74,144,217,0.15); background: #fff; }
        .form-control.is-invalid { border-color: #dc3545; }
        .btn-auth { background: #1e3a5f; color: #fff; border: none; border-radius: 10px; padding: 12px; font-size: 0.95rem; font-weight: 600; width: 100%; transition: background 0.2s; }
        .btn-auth:hover { background: #162d4a; color: #fff; }
        .form-check-input:checked { background-color: #1e3a5f; border-color: #1e3a5f; }
        .link-primary { color: #1e3a5f; text-decoration: none; font-weight: 600; }
        .link-primary:hover { color: #132744; text-decoration: underline; }
        .link-muted { color: #6c757d; text-decoration: none; font-size: 0.82rem; }
        .link-muted:hover { color: #1e3a5f; }
        .invalid-feedback-custom { color: #dc3545; font-size: 0.8rem; margin-top: 4px; }
        @media (max-width: 768px) {
            .auth-sidebar { display: none; }
            .auth-wrapper { max-width: 440px; border-radius: 16px; min-height: auto; }
            .auth-form-area { padding: 36px 28px; }
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-sidebar">
            <div>
                <div class="feature-icon" style="margin-bottom: 24px; width: 50px; height: 50px;">
                    <i class="bi bi-ticket-perforated" style="font-size: 22px;"></i>
                </div>
                <h2>{{ config('app.name', 'Laravel') }}</h2>
                <p class="subtitle">Gestiona tus tickets de soporte de forma rapida, sencilla y eficiente.</p>
                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-lightning-charge"></i></div>
                    <span>Respuestas rapidas y eficientes</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                    <span>Tus datos siempre seguros</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-graph-up-arrow"></i></div>
                    <span>Seguimiento en tiempo real</span>
                </div>
            </div>
        </div>
        <div class="auth-form-area">
            <h3>Bienvenido de nuevo</h3>
            <p class="desc">Introduce tus credenciales para acceder a tu cuenta.</p>

            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="font-size: 0.85rem; border-radius: 10px;">
                    <i class="bi bi-check-circle-fill me-1"></i> {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="tu@email.com" required autofocus autocomplete="username">
                    @error('email')
                        <div class="invalid-feedback-custom">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <label for="password" class="form-label mb-0">Contrasena</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="link-muted">Olvidaste tu contrasena?</a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password"
                           class="form-control mt-1 @error('password') is-invalid @enderror"
                           placeholder="Tu contrasena" required autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback-custom">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                    <label class="form-check-label" for="remember_me" style="font-size: 0.85rem; color: #6c757d;">Recuerdame</label>
                </div>

                <button type="submit" class="btn-auth">Iniciar Sesion</button>
            </form>

            @if (Route::has('register'))
                <p class="text-center mt-4 mb-0" style="font-size: 0.88rem; color: #6c757d;">
                    No tienes cuenta? <a href="{{ route('register') }}" class="link-primary">Registrate aqui</a>
                </p>
            @endif
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
