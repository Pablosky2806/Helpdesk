<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Ticket - HelpDesk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --primary-light: #eef2ff;
            --sidebar-w: 250px;
            --topbar-h: 60px;
        }
        * { font-family: 'Instrument Sans', system-ui, sans-serif; }
        body { margin: 0; background: #f4f6fb; }

        /* Sidebar */
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: #fff;
            border-right: 1px solid #eaecf0;
            display: flex; flex-direction: column;
            z-index: 100;
        }
        .sidebar-brand {
            height: var(--topbar-h);
            display: flex; align-items: center; gap: 10px;
            padding: 0 24px;
            font-weight: 700; font-size: 1rem; color: var(--primary);
            border-bottom: 1px solid #eaecf0;
        }
        .sidebar-brand i { font-size: 1.2rem; }
        .sidebar-nav { padding: 16px 12px; flex: 1; }
        .sidebar-nav .nav-link {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 16px; border-radius: 8px;
            font-size: .875rem; font-weight: 500;
            color: #475569; text-decoration: none;
            transition: all .15s;
            margin-bottom: 2px;
        }
        .sidebar-nav .nav-link:hover { background: #f8fafc; color: var(--primary); }
        .sidebar-nav .nav-link.active {
            background: var(--primary-light); color: var(--primary); font-weight: 600;
        }
        .sidebar-nav .nav-link i { font-size: 1.1rem; width: 20px; text-align: center; }
        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid #eaecf0;
            font-size: .82rem; color: #64748b;
        }

        /* Topbar */
        .topbar {
            position: fixed; top: 0; left: var(--sidebar-w); right: 0;
            height: var(--topbar-h);
            background: #fff; border-bottom: 1px solid #eaecf0;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 28px; z-index: 99;
        }
        .topbar h5 { font-size: 1rem; font-weight: 600; color: #1e293b; margin: 0; }
        .avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--primary); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 600; font-size: .8rem;
        }

        /* Main */
        .main { margin-left: var(--sidebar-w); padding-top: var(--topbar-h); }
        .main-inner { padding: 28px; }

        /* Form section */
        .section-card {
            background: #fff; border-radius: 12px; border: 1px solid #eaecf0;
            overflow: hidden;
            margin-bottom: 24px;
        }
        .section-header {
            padding: 18px 22px; border-bottom: 1px solid #eaecf0;
            background: #fafafa;
        }
        .section-header h6 { font-weight: 600; font-size: .9rem; color: #1e293b; margin: 0; }
        .section-body { padding: 24px; }
        .form-label { font-weight: 500; font-size: .85rem; color: #374151; margin-bottom: 6px; }
        .form-control, .form-select {
            border: 1px solid #d1d5db; border-radius: 8px;
            font-size: .85rem; padding: 10px 14px;
            transition: all .15s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary); box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        .section-title {
            font-size: 1.1rem; font-weight: 600; color: #1e293b;
            margin-bottom: 20px; padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-light);
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <i class="bi bi-ticket-detailed"></i> Sistema de Tickets
    </div>
    <nav class="sidebar-nav">
        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isTecnico() ? route('tecnico.dashboard') : route('client.dashboard')) }}" class="nav-link">
            <i class="bi bi-house-door"></i> Dashboard
        </a>
        <a href="{{ route('tickets.index') }}" class="nav-link">
            <i class="bi bi-collection"></i> Mis Tickets
        </a>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.users.index') }}" class="nav-link">
            <i class="bi bi-people"></i> Gestión Usuarios
        </a>
        @endif
        <a href="{{ route('tickets.create') }}" class="nav-link active">
            <i class="bi bi-plus-circle"></i> Crear Ticket
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="fw-semibold" style="color:#334155;">{{ Auth::user()->name ?? 'Usuario' }}</div>
        <form method="POST" action="{{ route('logout') }}" class="mt-1">
            @csrf
            <button type="submit" style="background:none;border:none;color:#ef4444;font-size:.8rem;font-weight:500;padding:0;cursor:pointer;">
                <i class="bi bi-box-arrow-left me-1"></i>Cerrar sesión
            </button>
        </form>
    </div>
</aside>

<!-- Topbar -->
<header class="topbar">
    <h5>Crear Nuevo Ticket</h5>
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('tickets.index') }}" class="btn btn-sm btn-outline-secondary" style="font-size:.82rem;font-weight:500;">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
        <div class="avatar">
            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
        </div>
    </div>
</header>

<!-- Main -->
<div class="main">
    <div class="main-inner">

        <form action="{{ route('tickets.store') }}" method="POST">
            @csrf

            <!-- Datos del cliente -->
            <div class="section-card">
                <div class="section-header">
                    <h6><i class="bi bi-person me-2"></i>Datos del Cliente</h6>
                </div>
                <div class="section-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre *</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Apellidos *</label>
                            <input type="text" name="apellidos" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" placeholder="Opcional">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Empresa</label>
                        <input type="text" name="empresa" class="form-control" placeholder="Opcional">
                    </div>
                </div>
            </div>

            <!-- Información del dispositivo -->
            <div class="section-card">
                <div class="section-header">
                    <h6><i class="bi bi-laptop me-2"></i>Información del Dispositivo</h6>
                </div>
                <div class="section-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tipo de dispositivo *</label>
                            <input type="text" name="tipo_dispositivo" class="form-control" required placeholder="Ej: Laptop, PC, Móvil">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Marca *</label>
                            <input type="text" name="marca" class="form-control" required placeholder="Ej: Dell, HP, Apple">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Modelo *</label>
                            <input type="text" name="modelo" class="form-control" required placeholder="Ej: XPS 15, Pavilion 15">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Número de serie</label>
                        <input type="text" name="numero_serie" class="form-control" placeholder="Opcional">
                    </div>
                </div>
            </div>

            <!-- Información del ticket -->
            <div class="section-card">
                <div class="section-header">
                    <h6><i class="bi bi-ticket-detailed me-2"></i>Información del Ticket</h6>
                </div>
                <div class="section-body">
                    <div class="mb-3">
                        <label class="form-label">Título *</label>
                        <input type="text" name="titulo" class="form-control" required placeholder="Describe brevemente el problema">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción *</label>
                        <textarea name="descripcion" class="form-control" rows="4" required placeholder="Describe detalladamente el problema que estás experimentando"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Categoría *</label>
                            <select name="categoria" class="form-select" required>
                                <option value="">Selecciona una categoría</option>
                                <option value="software">Software</option>
                                <option value="hardware">Hardware</option>
                                <option value="red">Red</option>
                                <option value="soporte_tecnico">Soporte técnico</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Prioridad *</label>
                            <select name="prioridad" class="form-select" required>
                                <option value="baja">Baja</option>
                                <option value="media" selected>Media</option>
                                <option value="alta">Alta</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-lg me-1"></i> Cancelar
                </a>
                <div>
                    <button type="submit" class="btn text-white" style="background:var(--primary);font-weight:500;">
                        <i class="bi bi-send me-1"></i> Crear Ticket
                    </button>
                </div>
            </div>

        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
