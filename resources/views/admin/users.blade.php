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
        .table-dash th {
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
            border-radius: 50px;
        }
        
        /* Botones de acción */
        .btn-action {
            padding: 6px 12px; border-radius: 6px;
            font-size: .75rem; font-weight: 500;
            text-decoration: none; border: none;
            cursor: pointer; transition: all .15s;
        }
        .btn-edit { background: #f59e0b; color: #fff; }
        .btn-edit:hover { background: #d97706; color: #fff; }
        .btn-delete { background: #ef4444; color: #fff; }
        .btn-delete:hover { background: #dc2626; color: #fff; }
        .btn-role { background: #6b7280; color: #fff; }
        .btn-role:hover { background: #374151; color: #fff; }
    </style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <i class="bi bi-ticket-detailed"></i> Sistema de Tickets
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="nav-link">
            <i class="bi bi-house-door"></i> Dashboard
        </a>
        <a href="{{ route('admin.users.index') }}" class="nav-link active">
            <i class="bi bi-people"></i> Gestión Usuarios
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
    <h5>Gestión de Usuarios</h5>
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.users.create') }}" class="btn btn-sm text-white" style="background:var(--primary);font-size:.82rem;font-weight:600;">
            <i class="bi bi-plus-lg me-1"></i> Nuevo Usuario
        </a>
        <div class="avatar">
            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
        </div>
    </div>
</header>

<!-- Main -->
<div class="main">
    <div class="main-inner">

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i> {{ session('success') }}
            </div>
        @endif

        <div class="section-card">
            <div class="section-header">
                <h6><i class="bi bi-people me-2"></i> Usuarios del Sistema</h6>
                <span class="badge-pill bg-primary">{{ $users->count() }} usuarios</span>
            </div>
            
            <div class="table-responsive">
                <table class="table table-dash mb-0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Fecha Registro</th>
                            <th>Rol</th>
                            <th>Acciones</th>
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
                            <td style="color:#94a3b8;font-size:.82rem;">{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                <!-- Formulario de Cambio de Rol -->
                                <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="d-flex align-items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" class="form-select form-select-sm" style="width: 140px; font-size: .8rem;">
                                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Cliente</option>
                                        <option value="tecnico" {{ $user->role === 'tecnico' ? 'selected' : '' }}>Técnico</option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrador</option>
                                    </select>
                                    <button type="submit" class="btn-action btn-role" {{ $user->id === Auth::id() ? 'disabled' : '' }}>
                                        <i class="bi bi-save me-1"></i> Actualizar
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <!-- Botón Editar -->
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn-action btn-edit" {{ $user->id === Auth::id() ? 'disabled' : '' }}>
                                        <i class="bi bi-pencil me-1"></i> Editar
                                    </a>
                                    
                                    <!-- Botón Eliminar -->
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete-form" {{ $user->id === Auth::id() ? 'd-none' : '' }}>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" onclick="return confirmDelete('{{ $user->name }}')">
                                            <i class="bi bi-trash me-1"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function confirmDelete(userName) {
    return confirm('¿Estás seguro de que deseas eliminar al usuario "' + userName + '"?\n\nEsta acción no se puede deshacer.');
}

document.addEventListener('DOMContentLoaded', function() {
    // Manejar formularios de eliminación con AJAX
    const deleteForms = document.querySelectorAll('.delete-form');
    
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Deshabilitar botón y mostrar loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Eliminando...';
            
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': formData.get('_token'),
                    'X-HTTP-Method-Override': 'DELETE'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mostrar mensaje de éxito
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-success border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center';
                    alertDiv.innerHTML = '<i class="bi bi-check-circle-fill me-2 fs-5"></i> ' + data.message;
                    
                    // Insertar alerta antes de la tabla
                    const mainInner = document.querySelector('.main-inner');
                    const sectionCard = document.querySelector('.section-card');
                    mainInner.insertBefore(alertDiv, sectionCard);
                    
                    // Remover la fila eliminada
                    const row = form.closest('tr');
                    row.remove();
                    
                    // Actualizar contador
                    const badge = document.querySelector('.badge-pill');
                    const currentCount = parseInt(badge.textContent);
                    badge.textContent = (currentCount - 1) + ' usuarios';
                    
                    // Remover alerta después de 3 segundos
                    setTimeout(() => {
                        alertDiv.remove();
                    }, 3000);
                } else {
                    alert('Error al eliminar usuario: ' + (data.message || 'Error desconocido'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al eliminar usuario. Por favor, inténtalo de nuevo.');
            })
            .finally(() => {
                // Restaurar botón
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    });
});
</script>
</body>
</html>
