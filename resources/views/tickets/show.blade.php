<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket #{{ $ticket->id }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h1 class="mb-4">Ticket #{{ $ticket->id }}</h1>

    <div class="card">
        <div class="card-body">

            <h5 class="card-title">{{ $ticket->titulo }}</h5>

            <p class="card-text mt-3">
                {{ $ticket->descripcion }}
            </p>

            <hr>

            <p><strong>Categoría:</strong> {{ ucfirst(str_replace('_', ' ', $ticket->categoria)) }}</p>
            <p><strong>Prioridad:</strong> {{ $ticket->prioridad_formateada }}</p>
            <p><strong>Estado:</strong> {{ $ticket->estado_formateado }}</p>
            <p><strong>Fecha:</strong> {{ $ticket->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Progreso:</strong> {{ $ticket->progreso }}%</p>

            @if($ticket->estado === 'cerrado')
                <p><strong>Tiempo de resolución:</strong> {{ $ticket->tiempo_resolucion }}</p>
            @endif

        </div>
    </div>

    <!-- Historial de cambios -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">📋 Historial de Cambios</h5>
        </div>
        <div class="card-body">
            @if($ticket->historial->count() > 0)
                <div class="timeline">
                    @foreach($ticket->historial as $cambio)
                        <div class="timeline-item mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="badge bg-{{ match($cambio->accion) {
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
                <p class="text-muted">No hay cambios registrados</p>
            @endif
        </div>
    </div>

    <a href="{{ route('tickets.index') }}" class="btn btn-link mt-3">
        ← Volver a tickets
    </a>

</div>

<style>
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
</style>

</body>
</html>
