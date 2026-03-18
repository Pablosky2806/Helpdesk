<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket #{{ $ticket->id }} - HelpDesk</title>
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

        /* Section cards */
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

        /* Timeline */
        .timeline {
            position: relative;
            padding-left: 20px;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e9ecef;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -24px;
            top: 8px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #6c757d;
        }
        .badge-pill {
            font-size: .7rem; font-weight: 600; padding: 3px 10px;
            border-radius: 20px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }
        .info-item {
            padding: 12px;
            background: #f8fafc;
            border-radius: 8px;
            border-left: 3px solid var(--primary);
        }
        .info-label {
            font-size: .75rem; color: #64748b; font-weight: 500;
            margin-bottom: 4px;
        }
        .info-value {
            font-size: .9rem; color: #1e293b; font-weight: 600;
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
        <a href="{{ route('client.dashboard') }}" class="nav-link">
            <i class="bi bi-house-door"></i> Dashboard
        </a>
        <a href="{{ route('tickets.index') }}" class="nav-link">
            <i class="bi bi-collection"></i> Mis Tickets
        </a>
        <a href="{{ route('tickets.create') }}" class="nav-link">
            <i class="bi bi-plus-circle"></i> Crear Ticket
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="fw-semibold" style="color:#334155;">{{ Auth::user()->name ?? 'Usuario' }}</div>
        <form method="POST" action="{{ route('logout') }}" class="mt-1">
            @csrf
            <button type="submit" style="background:none;border:none;color:#ef4444;font-size:.8rem;font-weight:500;padding:0;cursor:pointer;">
                <i class="bi bi-box-arrow-left me-1"></i>Cerrar sesion
            </button>
        </form>
    </div>
</aside>

<!-- Topbar -->
<header class="topbar">
    <h5>Ticket #{{ $ticket->id }} - {{ $ticket->titulo }}</h5>
    <div class="d-flex align-items-center gap-3">
        @if($ticket->estado !== 'cerrado')
            <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-sm btn-outline-warning" style="font-size:.82rem;font-weight:500;">
                <i class="bi bi-pencil me-1"></i> Editar
            </a>
            <form action="{{ route('tickets.close', $ticket) }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-sm btn-outline-danger" style="font-size:.82rem;font-weight:500;">
                    <i class="bi bi-x-circle me-1"></i> Cerrar
                </button>
            </form>
        @endif
        <div class="avatar">
            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
        </div>
    </div>
</header>

<!-- Main -->
<div class="main">
    <div class="main-inner">

        <!-- Información principal -->
        <div class="section-card">
            <div class="section-header">
                <h6><i class="bi bi-info-circle me-2"></i>Información del Ticket</h6>
            </div>
            <div class="section-body">
                <div class="mb-4">
                    <h4 class="mb-3">{{ $ticket->titulo }}</h4>
                    <p class="text-muted">{{ $ticket->descripcion }}</p>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">ID del Ticket</div>
                        <div class="info-value">#{{ $ticket->id }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Categoría</div>
                        <div class="info-value">{{ ucfirst(str_replace('_', ' ', $ticket->categoria)) }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Prioridad</div>
                        <div class="info-value">{{ $ticket->prioridad_formateada }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Estado</div>
                        <div class="info-value">{{ $ticket->estado_formateado }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Fecha de Creación</div>
                        <div class="info-value">{{ $ticket->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Progreso</div>
                        <div class="info-value">{{ $ticket->progreso }}%</div>
                    </div>
                    @if($ticket->estado === 'cerrado')
                        <div class="info-item">
                            <div class="info-label">Tiempo de Resolución</div>
                            <div class="info-value">{{ $ticket->tiempo_resolucion }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Información del cliente -->
        <div class="section-card">
            <div class="section-header">
                <h6><i class="bi bi-person me-2"></i>Información del Cliente</h6>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>Nombre:</strong> {{ $ticket->nombre }} {{ $ticket->apellidos }}
                        </div>
                        <div class="mb-3">
                            <strong>Email:</strong> {{ $ticket->email }}
                        </div>
                        <div class="mb-3">
                            <strong>Teléfono:</strong> {{ $ticket->telefono ?: 'No especificado' }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>Empresa:</strong> {{ $ticket->empresa ?: 'No especificada' }}
                        </div>
                        <div class="mb-3">
                            <strong>Tipo Dispositivo:</strong> {{ $ticket->tipo_dispositivo }}
                        </div>
                        <div class="mb-3">
                            <strong>Marca/Modelo:</strong> {{ $ticket->marca }} {{ $ticket->modelo }}
                        </div>
                    </div>
                </div>
                @if($ticket->numero_serie)
                    <div class="mt-3">
                        <strong>Número de Serie:</strong> {{ $ticket->numero_serie }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Historial de cambios -->
        <div class="section-card">
            <div class="section-header">
                <h6><i class="bi bi-clock-history me-2"></i>Historial de Cambios</h6>
            </div>
            <div class="section-body">
                @if($ticket->historial->count() > 0)
                    <div class="timeline">
                        @foreach($ticket->historial as $cambio)
                            <div class="timeline-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <span class="badge-pill bg-{{ match($cambio->accion) {
                                            'creacion' => 'primary',
                                            'cambio_estado' => 'info',
                                            'actualizacion' => 'warning',
                                            'cierre' => 'success',
                                            default => 'secondary'
                                        } }}">
                                            {{ ucfirst(str_replace('_', ' ', $cambio->accion)) }}
                                        </span>
                                        
                                        @if($cambio->estado_anterior && $cambio->estado_nuevo)
                                            <small class="text-muted ms-2">
                                                {{ ucfirst($cambio->estado_anterior) }} → {{ ucfirst($cambio->estado_nuevo) }}
                                            </small>
                                        @endif
                                    </div>
                                    <small class="text-muted">{{ $cambio->fecha_formateada }}</small>
                                </div>
                                
                                @if($cambio->comentarios)
                                    <p class="mb-1 mt-2 text-muted">{{ $cambio->comentarios }}</p>
                                @endif
                                
                                <small class="text-muted">
                                    Por: {{ $cambio->nombre_usuario }}
                                </small>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-clock-history" style="font-size: 2rem;"></i>
                        <p class="mt-2">No hay cambios registrados</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver a Mis Tickets
            </a>
            @if($ticket->estado !== 'cerrado')
                <div class="d-flex gap-2">
                    <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-outline-warning">
                        <i class="bi bi-pencil me-1"></i> Editar Ticket
                    </a>
                    <form action="{{ route('tickets.close', $ticket) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-x-circle me-1"></i> Cerrar Ticket
                        </button>
                    </form>
                </div>
            @endif
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
