<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .badge-priority { font-size: 0.8rem; }
        .badge-status { font-size: 0.8rem; }
    </style>
</head>
<body>

<div class="container mt-4 mb-5">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Gestion de Tickets</h1>
            <p class="text-muted mb-0">Gestiona todos los tickets del sistema</p>
        </div>
        <a href="{{ route('tickets.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Nuevo Ticket
        </a>
    </div>

    {{-- Mensaje si no hay tickets --}}
    @if($tickets->isEmpty())
        <div class="alert alert-info d-flex align-items-center" role="alert">
            <i class="bi bi-info-circle me-2"></i>
            No tienes tickets creados todavia.
        </div>
    @else
        {{-- Tabla de tickets --}}
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
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
                                <td>{{ $ticket->titulo }}</td>

                                <td>
                                    <span class="badge rounded-pill
                                        @if($ticket->prioridad === 'alta') bg-danger
                                        @elseif($ticket->prioridad === 'media') bg-warning text-dark
                                        @else bg-success
                                        @endif
                                    ">
                                        {{ ucfirst($ticket->prioridad) }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge rounded-pill
                                        @if($ticket->estado === 'abierto') bg-primary
                                        @elseif($ticket->estado === 'en_proceso') bg-warning text-dark
                                        @else bg-secondary
                                        @endif
                                    ">
                                        {{ str_replace('_', ' ', ucfirst($ticket->estado)) }}
                                    </span>
                                </td>

                                <td class="text-muted">{{ $ticket->created_at->format('d/m/Y') }}</td>

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
            <div class="card-footer bg-white text-muted small">
                Mostrando {{ $tickets->count() }} tickets
            </div>
        </div>
    @endif

    <a href="{{ route('dashboard') }}" class="btn btn-link mt-3 text-decoration-none">
        <i class="bi bi-arrow-left me-1"></i> Volver al dashboard
    </a>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
