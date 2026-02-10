<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'HelpDesk') }} - Gestor de Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f0f2f5; margin: 0; }

        /* Navbar */
        .navbar-custom { background: #fff; border-bottom: 1.5px solid #e0e3e8; padding: 14px 0; }
        .navbar-brand-custom { font-weight: 700; font-size: 1.2rem; color: #1e3a5f; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .navbar-brand-custom:hover { color: #1e3a5f; }
        .brand-icon { width: 38px; height: 38px; background: linear-gradient(145deg, #1e3a5f 0%, #132744 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; }
        .brand-icon i { font-size: 18px; color: #fff; }
        .btn-nav { border-radius: 10px; padding: 9px 24px; font-size: 0.88rem; font-weight: 600; transition: all 0.2s; }
        .btn-nav-outline { border: 1.5px solid #e0e3e8; color: #344054; background: transparent; }
        .btn-nav-outline:hover { border-color: #1e3a5f; color: #1e3a5f; background: rgba(30,58,95,0.04); }
        .btn-nav-primary { background: #1e3a5f; color: #fff; border: 1.5px solid #1e3a5f; }
        .btn-nav-primary:hover { background: #162d4a; color: #fff; border-color: #162d4a; }

        /* Hero */
        .hero-section { background: linear-gradient(145deg, #1e3a5f 0%, #132744 100%); color: #fff; padding: 80px 0 100px; position: relative; overflow: hidden; }
        .hero-section::before { content: ''; position: absolute; top: -50%; right: -20%; width: 600px; height: 600px; background: rgba(255,255,255,0.03); border-radius: 50%; }
        .hero-section::after { content: ''; position: absolute; bottom: -30%; left: -10%; width: 400px; height: 400px; background: rgba(255,255,255,0.02); border-radius: 50%; }
        .hero-badge { display: inline-flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15); border-radius: 50px; padding: 6px 16px; font-size: 0.8rem; color: rgba(255,255,255,0.8); margin-bottom: 24px; }
        .hero-badge i { font-size: 14px; }
        .hero-title { font-size: 3rem; font-weight: 800; line-height: 1.15; margin-bottom: 20px; }
        .hero-subtitle { font-size: 1.1rem; color: rgba(255,255,255,0.6); line-height: 1.7; max-width: 520px; margin-bottom: 36px; }
        .btn-hero { border-radius: 12px; padding: 14px 32px; font-size: 1rem; font-weight: 600; transition: all 0.2s; }
        .btn-hero-primary { background: #fff; color: #1e3a5f; border: none; }
        .btn-hero-primary:hover { background: #f0f2f5; color: #132744; transform: translateY(-1px); box-shadow: 0 4px 16px rgba(0,0,0,0.15); }
        .btn-hero-outline { background: transparent; color: #fff; border: 1.5px solid rgba(255,255,255,0.3); }
        .btn-hero-outline:hover { background: rgba(255,255,255,0.1); color: #fff; border-color: rgba(255,255,255,0.5); }
        .hero-stats { display: flex; gap: 48px; margin-top: 48px; }
        .hero-stat h4 { font-size: 1.75rem; font-weight: 700; margin-bottom: 2px; }
        .hero-stat span { font-size: 0.82rem; color: rgba(255,255,255,0.5); }

        /* Origin Story */
        .story-section { padding: 80px 0; background: #fff; }
        .story-card { background: #f8f9fb; border: 1.5px solid #e0e3e8; border-radius: 20px; padding: 48px; position: relative; overflow: hidden; }
        .story-card::before { content: '\F6B0'; font-family: 'bootstrap-icons'; position: absolute; top: -10px; right: 20px; font-size: 120px; color: rgba(30,58,95,0.04); }
        .story-icon { width: 56px; height: 56px; background: linear-gradient(145deg, #1e3a5f 0%, #132744 100%); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 24px; }
        .story-icon i { font-size: 24px; color: #fff; }
        .story-card h3 { font-size: 1.4rem; font-weight: 700; color: #1a1a2e; margin-bottom: 16px; }
        .story-card p { font-size: 0.95rem; color: #6c757d; line-height: 1.8; margin-bottom: 0; }
        .story-card .highlight { color: #1e3a5f; font-weight: 600; }
        .story-problems { list-style: none; padding: 0; margin: 20px 0 0; }
        .story-problems li { display: flex; align-items: flex-start; gap: 12px; padding: 10px 0; font-size: 0.9rem; color: #6c757d; }
        .story-problems li i { color: #dc3545; font-size: 16px; margin-top: 2px; flex-shrink: 0; }

        /* Features */
        .features-section { padding: 80px 0; background: #f0f2f5; }
        .section-badge { display: inline-flex; align-items: center; gap: 8px; background: rgba(30,58,95,0.08); border-radius: 50px; padding: 6px 16px; font-size: 0.8rem; color: #1e3a5f; font-weight: 600; margin-bottom: 16px; }
        .section-title { font-size: 2rem; font-weight: 800; color: #1a1a2e; margin-bottom: 12px; }
        .section-subtitle { font-size: 1rem; color: #6c757d; max-width: 560px; margin: 0 auto 48px; }
        .feature-card { background: #fff; border: 1.5px solid #e0e3e8; border-radius: 16px; padding: 32px 28px; height: 100%; transition: all 0.25s; }
        .feature-card:hover { border-color: #1e3a5f; box-shadow: 0 8px 30px rgba(30,58,95,0.1); transform: translateY(-4px); }
        .feature-card-icon { width: 50px; height: 50px; background: rgba(30,58,95,0.08); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; }
        .feature-card-icon i { font-size: 22px; color: #1e3a5f; }
        .feature-card h5 { font-size: 1.05rem; font-weight: 700; color: #1a1a2e; margin-bottom: 8px; }
        .feature-card p { font-size: 0.88rem; color: #6c757d; line-height: 1.6; margin-bottom: 0; }

        /* CTA */
        .cta-section { padding: 80px 0; background: #fff; }
        .cta-box { background: linear-gradient(145deg, #1e3a5f 0%, #132744 100%); border-radius: 24px; padding: 64px 48px; text-align: center; color: #fff; position: relative; overflow: hidden; }
        .cta-box::before { content: ''; position: absolute; top: -40%; right: -15%; width: 400px; height: 400px; background: rgba(255,255,255,0.04); border-radius: 50%; }
        .cta-box h3 { font-size: 2rem; font-weight: 800; margin-bottom: 12px; }
        .cta-box p { font-size: 1rem; color: rgba(255,255,255,0.6); margin-bottom: 32px; max-width: 480px; margin-left: auto; margin-right: auto; }

        /* Footer */
        .footer-custom { background: #f8f9fb; border-top: 1.5px solid #e0e3e8; padding: 32px 0; }
        .footer-custom p { font-size: 0.82rem; color: #98a2b3; margin: 0; }

        @media (max-width: 768px) {
            .hero-title { font-size: 2rem; }
            .hero-stats { flex-direction: column; gap: 20px; }
            .story-card { padding: 32px 24px; }
            .cta-box { padding: 40px 24px; }
            .cta-box h3 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar-custom">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="/" class="navbar-brand-custom">
                <div class="brand-icon"><i class="bi bi-ticket-perforated"></i></div>
                {{ config('app.name', 'HelpDesk') }}
            </a>
            @if (Route::has('login'))
                <div class="d-flex gap-2">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-nav btn-nav-primary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-nav btn-nav-outline">Iniciar sesion</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-nav btn-nav-primary">Registrarse</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero-section">
        <div class="container position-relative" style="z-index: 1;">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="hero-badge">
                        <i class="bi bi-stars"></i>
                        Gestor de tickets profesional
                    </div>
                    <h1 class="hero-title">Deja de usar post-its.<br>Gestiona tus tickets<br>como un profesional.</h1>
                    <p class="hero-subtitle">HelpDesk nacio de una necesidad real: organizar las incidencias, saber que dispositivo esta averiado, quien lo reporto y en que estado se encuentra. Todo en un solo lugar, sin caos ni papeles perdidos.</p>
                    <div class="d-flex gap-3 flex-wrap">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-hero btn-hero-primary">
                                <i class="bi bi-rocket-takeoff me-2"></i>Empezar gratis
                            </a>
                        @endif
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="btn btn-hero btn-hero-outline">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Ya tengo cuenta
                            </a>
                        @endif
                    </div>
                    <div class="hero-stats">
                        <div class="hero-stat">
                            <h4>100%</h4>
                            <span>Organizado</span>
                        </div>
                        <div class="hero-stat">
                            <h4>0</h4>
                            <span>Post-its necesarios</span>
                        </div>
                        <div class="hero-stat">
                            <h4>24/7</h4>
                            <span>Disponible siempre</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-flex justify-content-center align-items-center">
                    <div style="width: 320px; height: 320px; background: rgba(255,255,255,0.05); border-radius: 32px; border: 1.5px solid rgba(255,255,255,0.1); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 16px;">
                        <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.1); border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-ticket-perforated" style="font-size: 38px; color: rgba(255,255,255,0.8);"></i>
                        </div>
                        <div style="font-size: 1.3rem; font-weight: 700;">HelpDesk</div>
                        <div style="font-size: 0.82rem; color: rgba(255,255,255,0.45);">Tu gestor de incidencias</div>
                        <div style="display: flex; gap: 8px; margin-top: 8px;">
                            <div style="width: 10px; height: 10px; background: #28a745; border-radius: 50%;"></div>
                            <div style="width: 10px; height: 10px; background: #ffc107; border-radius: 50%;"></div>
                            <div style="width: 10px; height: 10px; background: #dc3545; border-radius: 50%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Origin Story -->
    <section class="story-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="story-card">
                        <div class="story-icon">
                            <i class="bi bi-lightbulb"></i>
                        </div>
                        <h3>Por que cree HelpDesk?</h3>
                        <p>Cuando trabajaba en una empresa, me encontre con un problema que muchos tecnicos conocen bien: <span class="highlight">no habia ningun sistema para gestionar las incidencias</span>. Todo se apuntaba en post-its pegados en la mesa, en papeles sueltos o simplemente se confiaba en la memoria.</p>
                        <p style="margin-top: 12px;">El resultado? Un caos total. <span class="highlight">No sabias que dispositivo era de quien</span>, que estaba reparado y que seguia esperando, ni cual era la prioridad de cada incidencia. Los post-its se perdian, se despegaban, se mezclaban... y al final el cliente esperaba y tu no tenias ni idea de por donde ibas.</p>
                        <p style="margin-top: 12px;">Fue entonces cuando decidi crear <span class="highlight">HelpDesk</span>: una herramienta sencilla pero potente para que ningun tecnico tenga que pasar por ese caos. Un sitio donde cada ticket tiene su cliente, su dispositivo, su estado y su prioridad, todo claro y accesible.</p>
                        <ul class="story-problems">
                            <li><i class="bi bi-x-circle-fill"></i> Post-its que se pierden y no sabes que dispositivo era de cada cliente</li>
                            <li><i class="bi bi-x-circle-fill"></i> Sin forma de saber que esta reparado y que sigue pendiente</li>
                            <li><i class="bi bi-x-circle-fill"></i> Imposible priorizar cuando todo esta apuntado en papeles sueltos</li>
                            <li><i class="bi bi-x-circle-fill"></i> El cliente llama y no tienes ni idea del estado de su reparacion</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="features-section">
        <div class="container text-center">
            <div class="section-badge"><i class="bi bi-gear"></i> Funcionalidades</div>
            <h2 class="section-title">Todo lo que necesitas para gestionar incidencias</h2>
            <p class="section-subtitle">HelpDesk te da las herramientas para tener el control total de cada ticket, desde que entra hasta que se cierra.</p>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-card-icon"><i class="bi bi-plus-circle"></i></div>
                        <h5>Crear tickets facilmente</h5>
                        <p>Registra nuevas incidencias en segundos con datos del cliente, dispositivo, descripcion y prioridad.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-card-icon"><i class="bi bi-kanban"></i></div>
                        <h5>Control de estados</h5>
                        <p>Cada ticket pasa por estados claros: abierto, en progreso y cerrado. Siempre sabes en que punto esta.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-card-icon"><i class="bi bi-flag"></i></div>
                        <h5>Prioridades</h5>
                        <p>Marca cada ticket como baja, media, alta o urgente para saber que atender primero.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-card-icon"><i class="bi bi-laptop"></i></div>
                        <h5>Datos del dispositivo</h5>
                        <p>Registra marca, modelo y numero de serie para no confundir nunca un dispositivo con otro.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-card-icon"><i class="bi bi-person-badge"></i></div>
                        <h5>Informacion del cliente</h5>
                        <p>Nombre, telefono y email del cliente siempre vinculados al ticket. Sin papeles ni confusiones.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-card-icon"><i class="bi bi-shield-check"></i></div>
                        <h5>Seguro y privado</h5>
                        <p>Solo tu equipo accede a los tickets. Cada usuario tiene su cuenta con acceso protegido.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="cta-box">
                        <h3>Deja los post-its y empieza a organizarte</h3>
                        <p>Crea tu cuenta en segundos y empieza a gestionar tus tickets de soporte de forma profesional. Sin complicaciones, sin papeles, sin caos.</p>
                        <div class="d-flex gap-3 justify-content-center flex-wrap">
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-hero btn-hero-primary">
                                    <i class="bi bi-rocket-takeoff me-2"></i>Crear cuenta gratis
                                </a>
                            @endif
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="btn btn-hero btn-hero-outline">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar sesion
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer-custom">
        <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'HelpDesk') }}. Todos los derechos reservados.</p>
            <p>Hecho con <i class="bi bi-heart-fill" style="color: #dc3545; font-size: 10px;"></i> para tecnicos que se merecen algo mejor que un post-it.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
