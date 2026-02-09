@php
    $tickets = \App\Models\Ticket::all();
@endphp
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
                <i class="bi bi-box-arrow-left me-1"></i>Cerrar sesion
            </button>
        </form>
    </div>
</aside>

<!-- Topbar -->
<header class="topbar">
    <h5>Dashboard</h5>
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
            <div class="mb-4">
    <button onclick="testFirestore()" class="btn btn-danger">
        Probar Firestore
    </button>
</div>

        <!-- Stat cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-xl-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="stat-label">Abiertos</span>
                        <span class="stat-icon" style="background:#eef2ff;color:#4f46e5;"><i class="bi bi-envelope-open"></i></span>
                    </div>
                    <div class="stat-value" style="color:#4f46e5;">{{ $tickets->where('estado', 'abierto')->count() }}</div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="stat-label">En Progreso</span>
                        <span class="stat-icon" style="background:#fef3c7;color:#d97706;"><i class="bi bi-clock-history"></i></span>
                    </div>
                    <div class="stat-value" style="color:#d97706;">{{ $tickets->where('estado', 'en_proceso')->count() }}</div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="stat-label">Cerrados</span>
                        <span class="stat-icon" style="background:#dcfce7;color:#16a34a;"><i class="bi bi-check-circle"></i></span>
                    </div>
                    <div class="stat-value" style="color:#16a34a;">{{ $tickets->where('estado', 'cerrado')->count() }}</div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="stat-label">Total</span>
                        <span class="stat-icon" style="background:#f1f5f9;color:#475569;"><i class="bi bi-collection"></i></span>
                    </div>
                    <div class="stat-value" style="color:#1e293b;">{{ $tickets->count() }}</div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Ultimos tickets -->
            <div class="col-lg-8">
                <div class="section-card">
                    <div class="section-header">
                        <h6>Ultimos Tickets</h6>
                        <a href="{{ route('tickets.index') }}">Ver todos <i class="bi bi-arrow-right"></i></a>
                    </div>
                    @if($tickets->isEmpty())
                        <div class="empty-box">
                            <i class="bi bi-inbox"></i>
                            <p>No hay tickets todavia</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-dash mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Titulo</th>
                                        <th>Prioridad</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tickets->sortByDesc('created_at')->take(5) as $t)
                                        <tr>
                                            <td class="fw-semibold">{{ $t->id }}</td>
                                            <td>
                                                <a href="{{ route('tickets.show', $t) }}" style="color:#334155;text-decoration:none;">{{ $t->titulo }}</a>
                                            </td>
                                            <td>
                                                @if($t->prioridad === 'alta')
                                                    <span class="badge-pill bg-danger bg-opacity-10 text-danger">Alta</span>
                                                @elseif($t->prioridad === 'media')
                                                    <span class="badge-pill bg-warning bg-opacity-10 text-warning">Media</span>
                                                @else
                                                    <span class="badge-pill bg-success bg-opacity-10 text-success">Baja</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($t->estado === 'abierto')
                                                    <span class="badge-pill bg-primary bg-opacity-10 text-primary">Abierto</span>
                                                @elseif($t->estado === 'en_proceso')
                                                    <span class="badge-pill bg-warning bg-opacity-10 text-warning">En progreso</span>
                                                @else
                                                    <span class="badge-pill bg-secondary bg-opacity-10 text-secondary">Cerrado</span>
                                                @endif
                                            </td>
                                            <td style="color:#94a3b8;font-size:.82rem;">{{ $t->created_at->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Resumen lateral -->
            <div class="col-lg-4 d-flex flex-column gap-3">
                <div class="section-card">
                    <div class="section-header"><h6>Por Prioridad</h6></div>
                    <div style="padding:14px 22px;">
                        <div class="summary-row">
                            <span>Alta</span>
                            <span class="badge-pill bg-danger bg-opacity-10 text-danger">{{ $tickets->where('prioridad', 'alta')->count() }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Media</span>
                            <span class="badge-pill bg-warning bg-opacity-10 text-warning">{{ $tickets->where('prioridad', 'media')->count() }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Baja</span>
                            <span class="badge-pill bg-success bg-opacity-10 text-success">{{ $tickets->where('prioridad', 'baja')->count() }}</span>
                        </div>
                    </div>
                </div>

                <div class="section-card">
                    <div class="section-header"><h6>Por Estado</h6></div>
                    <div style="padding:14px 22px;">
                        <div class="summary-row">
                            <span>Abierto</span>
                            <span class="badge-pill bg-primary bg-opacity-10 text-primary">{{ $tickets->where('estado', 'abierto')->count() }}</span>
                        </div>
                        <div class="summary-row">
                            <span>En Progreso</span>
                            <span class="badge-pill bg-warning bg-opacity-10 text-warning">{{ $tickets->where('estado', 'en_proceso')->count() }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Cerrado</span>
                            <span class="badge-pill bg-secondary bg-opacity-10 text-secondary">{{ $tickets->where('estado', 'cerrado')->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="module">
import { collection, query, where, onSnapshot } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js";
import { db } from "/resources/js/firebase.js";

const userId = @json(Auth::id());


const q = query(
    collection(db, "notifications"),
    where("user_id", "==", userId)
);

onSnapshot(q, (snapshot) => {
    snapshot.docChanges().forEach((change) => {
        if (change.type === "added") {
            alert(change.doc.data().mensaje);
        }
    });
});
</script>

</body>
</html>
