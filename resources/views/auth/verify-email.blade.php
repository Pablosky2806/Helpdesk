<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verificar email - {{ config('app.name', 'Laravel') }}</title>
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
        .auth-form-area .desc { font-size: 0.9rem; color: #6c757d; margin-bottom: 28px; line-height: 1.6; }
        .btn-auth { background: #1e3a5f; color: #fff; border: none; border-radius: 10px; padding: 12px; font-size: 0.95rem; font-weight: 600; width: 100%; transition: background 0.2s; cursor: pointer; }
        .btn-auth:hover { background: #162d4a; color: #fff; }
        .btn-outline-auth { background: transparent; color: #6c757d; border: 1.5px solid #e0e3e8; border-radius: 10px; padding: 12px; font-size: 0.95rem; font-weight: 600; width: 100%; transition: all 0.2s; cursor: pointer; }
        .btn-outline-auth:hover { background: #f8f9fb; color: #1e3a5f; border-color: #1e3a5f; }
        .link-primary { color: #1e3a5f; text-decoration: none; font-weight: 600; }
        .link-primary:hover { color: #132744; text-decoration: underline; }
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
            <div style="text-align: center; margin-bottom: 24px;">
                <div class="feature-icon" style="width: 64px; height: 64px; background: rgba(30,58,95,0.08); border-radius: 16px; margin: 0 auto 16px;">
                    <i class="bi bi-envelope-check" style="font-size: 28px; color: #1e3a5f;"></i>
                </div>
            </div>
            <h3 style="text-align: center;">Verifica tu email</h3>
            <p class="desc" style="text-align: center;">Gracias por registrarte. Antes de empezar, verifica tu direccion de email haciendo clic en el enlace que te acabamos de enviar. Si no recibiste el email, te enviaremos otro con gusto.</p>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="font-size: 0.85rem; border-radius: 10px;">
                    <i class="bi bi-check-circle-fill me-1"></i> Se ha enviado un nuevo enlace de verificacion a tu email.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-auth mb-3">Reenviar email de verificacion</button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-outline-auth">Cerrar sesion</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
