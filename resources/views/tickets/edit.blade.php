<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Ticket #{{ $ticket->id }} - HelpDesk</title>
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
        .form-range::-webkit-slider-thumb {
            background: var(--primary);
        }
        .form-range::-moz-range-thumb {
            background: var(--primary);
        }
        .progress-section {
            background: linear-gradient(135deg, var(--primary-light) 0%, #fff 100%);
            border-radius: 12px;
            padding: 20px;
            border: 1px solid rgba(79, 70, 229, 0.1);
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
    <h5>Editar Ticket #{{ $ticket->id }}</h5>
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-outline-info" style="font-size:.82rem;font-weight:500;">
            <i class="bi bi-eye me-1"></i> Ver
        </a>
        <div class="avatar">
            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
        </div>
    </div>
</header>

<!-- Main -->
<div class="main">
    <div class="main-inner">

        <form action="{{ route('tickets.update', $ticket) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Información principal -->
            <div class="section-card">
                <div class="section-header">
                    <h6><i class="bi bi-pencil me-2"></i>Información del Ticket</h6>
                </div>
                <div class="section-body">
                    <div class="mb-4">
                        <label class="form-label">Título *</label>
                        <input type="text" name="titulo" class="form-control" 
                               value="{{ $ticket->titulo }}" required
                               placeholder="Describe brevemente el problema">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Descripción *</label>
                        <textarea name="descripcion" class="form-control" rows="4" required
                                  placeholder="Describe detalladamente el problema que estás experimentando">{{ $ticket->descripcion }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Categoría *</label>
                            <select name="categoria" class="form-select" required>
                                @foreach(['software', 'hardware', 'red', 'soporte_tecnico'] as $cat)
                                    <option value="{{ $cat }}"
                                        @selected($ticket->categoria === $cat)>
                                        {{ ucfirst(str_replace('_', ' ', $cat)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Prioridad *</label>
                            <select name="prioridad" class="form-select" required>
                                @foreach(['baja', 'media', 'alta'] as $prio)
                                    <option value="{{ $prio }}"
                                        @selected($ticket->prioridad === $prio)>
                                        {{ ucfirst($prio) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Estado *</label>
                            <select name="estado" class="form-select" required>
                                <option value="abierto" @selected($ticket->estado === 'abierto')>Abierto</option>
                                <option value="en_proceso" @selected($ticket->estado === 'en_proceso')>En Proceso</option>
                                <option value="cerrado" @selected($ticket->estado === 'cerrado')>Cerrado</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Progreso (%)</label>
                            <input type="number" name="progreso" class="form-control" min="0" max="100" value="{{ $ticket->progreso }}" placeholder="0-100">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progreso -->
            <div class="section-card">
                <div class="section-header">
                    <h6><i class="bi bi-graph-up me-2"></i>Progreso de Reparación</h6>
                </div>
                <div class="section-body">
                    <div class="progress-section">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="form-label mb-0 fw-bold text-primary">
                                <i class="bi bi-speedometer2 me-2"></i>Progreso Actual
                            </label>
                            <span id="progresoValor" class="badge bg-primary fs-6">{{ $ticket->progreso }}%</span>
                        </div>
                        
                        <input type="range" class="form-range mb-3" name="progreso" id="progreso" 
                               min="0" max="100" step="5" value="{{ $ticket->progreso }}"
                               oninput="document.getElementById('progresoValor').innerText = this.value + '%'">
                        
                        <div class="d-flex justify-content-between text-muted" style="font-size: 0.8rem;">
                            <span>0%<br><small>Recibido</small></span>
                            <span class="text-center">25%<br><small>Diagnóstico</small></span>
                            <span class="text-center">50%<br><small>En Reparación</small></span>
                            <span class="text-center">75%<br><small>Pruebas</small></span>
                            <span class="text-end">100%<br><small>Completado</small></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información actual -->
            <div class="section-card">
                <div class="section-header">
                    <h6><i class="bi bi-info-circle me-2"></i>Estado Actual</h6>
                </div>
                <div class="section-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Estado Actual:</strong> 
                                <span class="badge bg-@if($ticket->estado === 'abierto') primary @elseif($ticket->estado === 'en_proceso') warning @else secondary @endif ms-2">{{ $ticket->estado_formateado }}</span>
                            </div>
                            <div class="mb-3">
                                <strong>Fecha Creación:</strong> {{ $ticket->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Última Actualización:</strong> {{ $ticket->updated_at->format('d/m/Y H:i') }}
                            </div>
                            <div class="mb-3">
                                <strong>ID Ticket:</strong> #{{ $ticket->id }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg me-1"></i> Cancelar
                    </a>
                    <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary ms-2">
                        <i class="bi bi-list me-1"></i> Ver Todos
                    </a>
                </div>
                <div>
                    <button type="submit" class="btn text-white" style="background:var(--primary);font-weight:500;">
                        <i class="bi bi-check-lg me-1"></i> Actualizar Ticket
                    </button>
                </div>
            </div>

        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
