<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - Admin</title>
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
        
        /* Topbar & Sidebar reducidos para la demo */
        .sidebar { position: fixed; top: 0; left: 0; bottom: 0; width: var(--sidebar-w); background: #fff; border-right: 1px solid #eaecf0; display: flex; flex-direction: column; z-index: 100; }
        .sidebar-brand { height: var(--topbar-h); display: flex; align-items: center; gap: 10px; padding: 0 24px; font-weight: 700; font-size: 1rem; color: var(--primary); border-bottom: 1px solid #eaecf0; }
        .sidebar-nav { padding: 16px 12px; flex: 1; }
        .sidebar-nav .nav-link { display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 8px; font-size: .875rem; font-weight: 500; color: #475569; text-decoration: none; transition: all .15s; margin-bottom: 2px; }
        .sidebar-nav .nav-link:hover { background: #f8fafc; color: var(--primary); }
        .sidebar-nav .nav-link.active { background: var(--primary-light); color: var(--primary); font-weight: 600; }
        
        .topbar { position: fixed; top: 0; left: var(--sidebar-w); right: 0; height: var(--topbar-h); background: #fff; border-bottom: 1px solid #eaecf0; display: flex; align-items: center; justify-content: space-between; padding: 0 28px; z-index: 99; }
        .main { margin-left: var(--sidebar-w); padding-top: var(--topbar-h); min-height: 100vh; }
        .main-inner { padding: 32px; max-width: 1200px; margin: 0 auto; }
        
        .section-card { background: #fff; border-radius: 12px; border: 1px solid #eaecf0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .section-header { padding: 20px 24px; border-bottom: 1px solid #eaecf0; background: #fafafa; }
        
        .table-users th { background: #f8fafc; font-size: .75rem; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; color: #64748b; padding: 12px 24px; border-bottom: 2px solid #eaecf0; }
        .table-users td { padding: 16px 24px; font-size: .85rem; color: #334155; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand"><i class="bi bi-ticket-detailed"></i> Sistema de Tickets</div>
    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="bi bi-house-door"></i> Dashboard</a>
        <a href="{{ route('admin.users.index') }}" class="nav-link active"><i class="bi bi-people"></i> Gestión Usuarios</a>
        <a href="{{ route('tickets.index') }}" class="nav-link"><i class="bi bi-collection"></i> Tickets</a>
    </nav>
</aside>

<header class="topbar">
    <h5 class="m-0 fw-bold" style="font-size: 1rem;">Administración de Usuarios</h5>
    <div class="d-flex align-items-center gap-3 text-muted" style="font-size: .85rem;">
        Admin: <span class="fw-bold text-dark">{{ Auth::user()->name ?? 'Administrador' }}</span>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm ms-2">Volver</a>
    </div>
</header>

<div class="main">
    <div class="main-inner">
        
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i> {{ session('success') }}
            </div>
        @endif

        <div class="section-card">
            <div class="section-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-dark"><i class="bi bi-person-lines-fill me-2"></i> Usuarios del Sistema</h6>
                <span class="badge bg-primary rounded-pill">{{ $users->count() }} total</span>
            </div>
            
            <div class="table-responsive">
                <table class="table table-users mb-0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Fecha Registro</th>
                            <th>Rol / Permisos</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                                @if($user->firebase_uid)
                                    <small class="text-primary" style="font-size: .7rem;"><i class="bi bi-google"></i> Google Auth</small>
                                @endif
                            </td>
                            <td>{{ $user->email }}</td>
                            <td class="text-muted">{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <!-- Formulario de Cambio de Rol -->
                                <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="d-flex align-items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" class="form-select form-select-sm" style="width: 140px; font-size: .8rem;">
                                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Cliente (User)</option>
                                        <option value="tecnico" {{ $user->role === 'tecnico' ? 'selected' : '' }}>Trabajador (Técnico)</option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrador</option>
                                    </select>
                            </td>
                            <td class="text-end">
                                    <button type="submit" class="btn btn-sm btn-primary" style="font-size: .75rem; font-weight: 500;" {{ $user->id === Auth::id() ? 'disabled' : '' }}>
                                        <i class="bi bi-save me-1"></i> Actualizar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

</body>
</html>
