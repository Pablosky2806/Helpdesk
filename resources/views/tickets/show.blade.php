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
            <p><strong>Prioridad:</strong> {{ ucfirst($ticket->prioridad) }}</p>
            <p><strong>Estado:</strong> {{ ucfirst(str_replace('_', ' ', $ticket->estado)) }}</p>
            <p><strong>Fecha:</strong> {{ $ticket->created_at->format('d/m/Y H:i') }}</p>

        </div>
    </div>

    <a href="{{ route('tickets.index') }}" class="btn btn-link mt-3">
        ← Volver a tickets
    </a>

</div>

</body>
</html>
