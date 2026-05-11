<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión - {{ config('app.name', 'Laravel') }}</title>
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
                        <label for="password" class="form-label mb-0">Contraseña</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="link-muted">Olvidaste tu contraseña?</a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password"
                           class="form-control mt-1 @error('password') is-invalid @enderror"
                           placeholder="Tu contraseña" required autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback-custom">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                    <label class="form-check-label" for="remember_me" style="font-size: 0.85rem; color: #6c757d;">Recuérdame</label>
                </div>

                <button type="submit" class="btn-auth">Iniciar Sesión</button>
            </form>

            <!-- Separador -->
            <div class="text-center my-4" style="position: relative;">
                <div style="position: absolute; top: 50%; left: 0; right: 0; height: 1px; background: #e5e7eb;"></div>
                <span style="background: #f0f2f5; padding: 0 16px; color: #6b7280; font-size: 0.85rem; position: relative;">O continúa con</span>
            </div>

            <!-- Botón de Google -->
            <button id="google-login-btn" class="btn-google" style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; background: white; color: #374151; font-weight: 500; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.2s;">
                <svg width="18" height="18" viewBox="0 0 24 24" style="fill: #4285f4;">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" style="fill: #34a853;"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" style="fill: #fbbc05;"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" style="fill: #ea4335;"/>
                </svg>
                Google
            </button>

            @if (Route::has('register'))
                <p class="text-center mt-4 mb-0" style="font-size: 0.88rem; color: #6c757d;">
                    ¿No tienes cuenta? <a href="{{ route('register') }}" class="link-primary">Regístrate aquí</a>
                </p>
            @endif
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-app.js";
    import { getAuth, signInWithPopup, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-auth.js";

    const firebaseConfig = {
        apiKey: "AIzaSyATyVyZ5WWXQlLRSDkMNw05Jy8ZPWqCXX8",
        authDomain: "helpdesk-bf465.firebaseapp.com",
        projectId: "helpdesk-bf465",
        storageBucket: "helpdesk-bf465.appspot.com",
        messagingSenderId: "18276183668",
        appId: "1:18276183668:web:360089478b5907e5b4ab21",
        measurementId: "G-DG7TX4GYQP"
    };

    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);
    const provider = new GoogleAuthProvider();

    document.getElementById('google-login-btn').addEventListener('click', async () => {
        try {
            const result = await signInWithPopup(auth, provider);
            const user = result.user;
            
            // Enviar datos al backend
            const response = await fetch('/firebase/verify', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    uid: user.uid,
                    email: user.email,
                    name: user.displayName,
                    avatar: user.photoURL
                })
            });

            if (response.ok) {
                window.location.href = '/dashboard';
            } else {
                alert('Error al verificar usuario con el servidor');
            }
        } catch (error) {
            console.error('Error de autenticación:', error);
            alert('Error al iniciar sesión con Google');
        }
    });
</script>
</body>
</html>
