<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
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

        /* Stat cards */
        .stat-card {
            background: #fff; border-radius: 12px; padding: 22px;
            border: 1px solid #eaecf0;
        }
        .stat-label { font-size: .8rem; font-weight: 500; color: #64748b; margin-bottom: 8px; }
        .stat-value { font-size: 2rem; font-weight: 700; line-height: 1; }
        .stat-icon {
            width: 40px; height: 40px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.05rem;
        }

        /* Table section */
        .section-card {
            background: #fff; border-radius: 12px; border: 1px solid #eaecf0;
            overflow: hidden;
        }
        .section-header {
            padding: 18px 22px; border-bottom: 1px solid #eaecf0;
            display: flex; justify-content: space-between; align-items: center;
        }
        .section-header h6 { font-weight: 600; font-size: .9rem; color: #1e293b; margin: 0; }
        .section-header a { font-size: .8rem; color: var(--primary); text-decoration: none; font-weight: 500; }
        .table-dash thead th {
            background: #f8fafc; font-size: .75rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: .4px; color: #64748b;
            padding: 10px 20px; border: none;
        }
        .table-dash tbody td {
            padding: 12px 20px; font-size: .85rem; color: #334155;
            border-bottom: 1px solid #f1f5f9; vertical-align: middle;
        }
        .table-dash tbody tr:last-child td { border-bottom: none; }
        .badge-pill {
            font-size: .7rem; font-weight: 600; padding: 3px 10px;
            border-radius: 20px;
        }
        .empty-box { padding: 40px; text-align: center; color: #94a3b8; }
        .empty-box i { font-size: 2rem; margin-bottom: 8px; display: block; color: #cbd5e1; }
        .summary-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: 10px 0; font-size: .85rem; color: #334155;
        }
        .summary-row + .summary-row { border-top: 1px solid #f1f5f9; }
    </style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <i class="bi bi-ticket-detailed"></i> Sistema de Tickets
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}" class="nav-link active">
            <i class="bi bi-house-door"></i> Dashboard
        </a>
        <a href="{{ route('tickets.index') }}" class="nav-link">
            <i class="bi bi-collection"></i> Tickets
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
                <i class="bi bi-box-arrow-left me-1"></i>Cerrar sesión
            </button>
        </form>
    </div>
</aside>

<!-- Topbar -->
<header class="topbar">
    <h5>Mi Panel (Cliente)</h5>
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('tickets.create') }}" class="btn btn-sm text-white" style="background:var(--primary);font-size:.82rem;font-weight:600;">
            <i class="bi bi-plus-lg me-1"></i> Nuevo Ticket
        </a>
        <div class="avatar">
            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
        </div>
    </div>
</header>

<!-- Main -->
<div class="main">
    <div class="main-inner">


        <div class="row g-4">
            <!-- Dispositivos en Reparación -->
            <div class="col-lg-12">
                <div class="section-card mb-4" style="border: none; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);">
                    <div class="section-header" style="background: var(--primary); padding: 24px; border-bottom: none;">
                        <h5 style="color: white; margin: 0; font-weight: 600;"><i class="bi bi-tools me-2"></i> Mis Reparaciones Activas</h5>
                    </div>
                    
                    <div style="padding: 24px;">
                    @php
                        $activeTickets = $tickets->whereIn('estado', ['abierto', 'en_proceso'])->sortByDesc('created_at');
                    @endphp

                    @if($activeTickets->isEmpty())
                        <div class="empty-box" style="padding: 60px 20px;">
                            <i class="bi bi-check-circle" style="color: #10b981; font-size: 3rem;"></i>
                            <h5 style="color: #334155; margin-top: 16px;">Todo al día</h5>
                            <p style="color: #64748b;">No tienes ningún dispositivo en reparación actualmente.</p>
                            <a href="{{ route('tickets.create') }}" class="btn btn-primary mt-3" style="background: var(--primary); border: none; padding: 10px 24px; font-weight: 500;">Solicitar Reparación</a>
                        </div>
                    @else
                        <div class="row g-4">
                            @foreach($activeTickets as $t)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100" style="border: 1px solid #e1e7ef; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); transition: transform 0.2s;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <span class="badge bg-light text-dark border mb-2" style="font-weight: 500; font-size: 0.75rem;">
                                                        <i class="bi bi-phone"></i> {{ strtoupper($t->tipo_dispositivo) }}
                                                    </span>
                                                    <h6 class="card-title fw-bold text-truncate" style="color: #1e293b; margin-bottom: 2px;">
                                                        <a href="{{ route('tickets.show', $t) }}" style="color: inherit; text-decoration: none;">{{ $t->titulo }}</a>
                                                    </h6>
                                                    <small class="text-muted">{{ $t->marca }} {{ $t->modelo }}</small>
                                                </div>
                                                <span class="badge {{ $t->estado === 'abierto' ? 'bg-primary' : 'bg-warning text-dark' }}" style="font-size: 0.7rem;">
                                                    {{ $t->estado === 'abierto' ? 'Recibido' : 'En Taller' }}
                                                </span>
                                            </div>

                                            <div class="mt-4 pt-2">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span class="text-muted" style="font-size: 0.8rem; font-weight: 600;">Progreso de la reparación</span>
                                                    <span class="fw-bold" style="font-size: 0.8rem; color: var(--primary);">{{ $t->progreso }}%</span>
                                                </div>
                                                <div class="progress" style="height: 10px; border-radius: 10px; background-color: #f1f5f9;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $t->progreso }}%; background-color: var(--primary); border-radius: 10px;" aria-valuenow="{{ $t->progreso }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                
                                                <div class="mt-3 text-center">
                                                    @if($t->progreso == 0)
                                                        <small class="text-muted d-block" style="font-size: 0.75rem;"><i class="bi bi-box me-1"></i> Dispositivo recibido, en cola de diagnóstico</small>
                                                    @elseif($t->progreso > 0 && $t->progreso <= 25)
                                                        <small class="text-primary d-block" style="font-size: 0.75rem;"><i class="bi bi-search me-1"></i> Técnico realizando diagnóstico inicial</small>
                                                    @elseif($t->progreso > 25 && $t->progreso <= 75)
                                                        <small class="text-warning d-block" style="font-size: 0.75rem;;font-weight: 600;"><i class="bi bi-tools me-1"></i> En proceso de reparación</small>
                                                    @elseif($t->progreso > 75 && $t->progreso < 100)
                                                        <small class="text-info d-block" style="font-size: 0.75rem;"><i class="bi bi-shield-check me-1"></i> Realizando pruebas de calidad finales</small>
                                                    @elseif($t->progreso == 100)
                                                        <small class="text-success d-block" style="font-size: 0.75rem; font-weight:600;"><i class="bi bi-check2-all me-1"></i> ¡Reparación completada! Listo para recoger</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-transparent border-top-0 pt-0 pb-3 px-3">
                                             <a href="{{ route('tickets.show', $t) }}" class="btn btn-light btn-sm w-100" style="color: #475569; font-weight: 500; font-size: 0.8rem;">Ver Detalles Adicionales</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    </div>
                </div>
            </div>

            <!-- Historial -->
            <div class="col-lg-12">
                <div class="section-card">
                    <div class="section-header">
                        <h6><i class="bi bi-clock-history me-2 text-muted"></i> Historial de Reparaciones (Completadas)</h6>
                    </div>
                    @php
                        $closedTickets = $tickets->where('estado', 'cerrado')->sortByDesc('updated_at');
                    @endphp
                    
                    @if($closedTickets->isEmpty())
                        <div class="empty-box" style="padding: 30px;">
                            <p style="margin:0; font-size: 0.9rem;">No tienes reparaciones completadas en el historial.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-dash mb-0">
                                <thead>
                                    <tr>
                                        <th>Dispositivo</th>
                                        <th>Problema Reportado</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($closedTickets->take(5) as $t)
                                        <tr>
                                            <td class="fw-semibold">
                                                <a href="{{ route('tickets.show', $t) }}" style="color:#334155;text-decoration:none;">{{ $t->marca }} {{ $t->modelo }}</a>
                                            </td>
                                            <td><span class="text-truncate d-inline-block" style="max-width: 250px;">{{ $t->titulo }}</span></td>
                                            <td style="color:#64748b;font-size:.82rem;">{{ $t->created_at->format('d/m/Y') }}</td>
                                            <td style="color:#64748b;font-size:.82rem;">{{ $t->updated_at->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
