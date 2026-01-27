<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket #{{ $ticket->id }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h1 class="mb-4">
        Ticket #{{ $ticket->id }} — {{ $ticket->titulo }}
    </h1>

    <div class="card mb-4">
        <div class="card-body">

            <p><strong>Descripción:</strong></p>
            <p>{{ $ticket->descripcion }}</p>

            <hr>

            <p><strong>Estado:</strong>
                <span class="badge bg-primary">
                    {{ ucfirst(str_replace('_', ' ', $ticket->estado)) }}
                </span>
            </p>

            <p><strong>Creado el:</strong>
                {{ $ticket->created_at->format('d/m/Y H:i') }}
            </p>

        </div>
    </div>

    <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
        ← Volver a tickets
    </a>

</div>

</body>
</html>
