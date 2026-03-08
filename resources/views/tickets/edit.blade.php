<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Editar ticket</h1>

    <form action="{{ route('tickets.update', $ticket) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control"
                   value="{{ $ticket->titulo }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="4" required>
{{ $ticket->descripcion }}
            </textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Categoría</label>
            <select name="categoria" class="form-select" required>
                @foreach(['software', 'hardware', 'red', 'soporte_tecnico'] as $cat)
                    <option value="{{ $cat }}"
                        @selected($ticket->categoria === $cat)>
                        {{ ucfirst(str_replace('_', ' ', $cat)) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Prioridad</label>
            <select name="prioridad" class="form-select" required>
                @foreach(['baja', 'media', 'alta'] as $prio)
                    <option value="{{ $prio }}"
                        @selected($ticket->prioridad === $prio)>
                        {{ ucfirst($prio) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4 pt-3 border-top">
            <label class="form-label d-flex justify-content-between align-items-center">
                <span class="fw-bold text-primary">Progreso de Reparación</span>
                <span id="progresoValor" class="badge bg-primary fs-6">{{ $ticket->progreso }}%</span>
            </label>
            <input type="range" class="form-range" name="progreso" id="progreso" 
                   min="0" max="100" step="5" value="{{ $ticket->progreso }}"
                   oninput="document.getElementById('progresoValor').innerText = this.value + '%'">
            
            <div class="d-flex justify-content-between text-muted" style="font-size: 0.8rem;">
                <span>0%<br><small>Recibido</small></span>
                <span class="text-center">50%<br><small>En Taller</small></span>
                <span class="text-end">100%<br><small>Listo</small></span>
            </div>
        </div>

        <button class="btn btn-warning">Actualizar ticket</button>
    </form>
</div>

</body>
</html>
