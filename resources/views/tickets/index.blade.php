<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestión de Tickets</h1>

        <a href="{{ route('tickets.create') }}" class="btn btn-primary">
            + Nuevo Ticket
        </a>

    </div>

    @if($tickets->isEmpty())
        <div class="alert alert-info">
            No tienes tickets creados todavía.
        </div>
    @else
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Prioridad</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->id }}</td>
                        <td>{{ $ticket->titulo }}</td>

                        <td>
                            <span class="badge 
                                @if($ticket->prioridad === 'alta') bg-danger
                                @elseif($ticket->prioridad === 'media') bg-warning text-dark
                                @else bg-success
                                @endif
                            ">
                                {{ ucfirst($ticket->prioridad) }}
                            </span>
                        </td>

                        <td>
                            <span class="badge 
                                @if($ticket->estado === 'abierto') bg-primary
                                @elseif($ticket->estado === 'en_proceso') bg-warning text-dark
                                @else bg-secondary
                                @endif
                            ">
                                {{ str_replace('_', ' ', ucfirst($ticket->estado)) }}
                            </span>
                        </td>

                        <td>{{ $ticket->created_at->format('d/m/Y') }}</td>

                        <td>
                            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-info">Ver</a>
                            <a href="#" class="btn btn-sm btn-warning">Editar</a>
                            <a href="#" class="btn btn-sm btn-danger">Eliminar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('dashboard') }}" class="btn btn-link mt-3">
        ← Volver al dashboard
    </a>

</div>

</body>
</html>
