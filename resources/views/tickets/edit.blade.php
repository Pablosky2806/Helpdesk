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

        <button class="btn btn-warning">Actualizar ticket</button>
    </form>
</div>

</body>
</html>
