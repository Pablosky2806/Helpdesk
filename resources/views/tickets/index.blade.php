<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Tickets - HelpDesk</title>
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
        <a href="{{ route('tickets.index') }}" class="nav-link active">
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
    <h5>Mis Tickets</h5>
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

        @if($tickets->isEmpty())
            <div class="section-card">
                <div class="empty-box">
                    <i class="bi bi-inbox"></i>
                    <p>No tienes tickets creados todavia</p>
                    <a href="{{ route('tickets.create') }}" class="btn btn-primary btn-sm mt-2">
                        <i class="bi bi-plus-lg me-1"></i> Crear mi primer ticket
                    </a>
                </div>
            </div>
        @else
            <div class="section-card">
                <div class="section-header">
                    <h6>Listado de Tickets</h6>
                    <span class="badge bg-primary">{{ $tickets->count() }} tickets</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-dash mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Titulo</th>
                                <th>Prioridad</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                                <tr>
                                    <td class="fw-semibold">{{ $ticket->id }}</td>
                                    <td>
                                        <a href="{{ route('tickets.show', $ticket) }}" style="color:#334155;text-decoration:none;">
                                            {{ $ticket->titulo }}
                                        </a>
                                    </td>
                                    <td>
                                        @if($ticket->prioridad === 'alta')
                                            <span class="badge-pill bg-danger bg-opacity-10 text-danger">Alta</span>
                                        @elseif($ticket->prioridad === 'media')
                                            <span class="badge-pill bg-warning bg-opacity-10 text-warning">Media</span>
                                        @else
                                            <span class="badge-pill bg-success bg-opacity-10 text-success">Baja</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($ticket->estado === 'abierto')
                                            <span class="badge-pill bg-primary bg-opacity-10 text-primary">Abierto</span>
                                        @elseif($ticket->estado === 'en_proceso')
                                            <span class="badge-pill bg-warning bg-opacity-10 text-warning">En progreso</span>
                                        @else
                                            <span class="badge-pill bg-secondary bg-opacity-10 text-secondary">Cerrado</span>
                                        @endif
                                    </td>
                                    <td style="color:#94a3b8;font-size:.82rem;">{{ $ticket->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1">
                                            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-outline-info" title="Ver">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            @if($ticket->estado !== 'cerrado')
                                                <form action="{{ route('tickets.close', $ticket) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary" title="Cerrar">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
