<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Ticket</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Crear nuevo ticket</h1>

    <form action="{{ route('tickets.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Título</label>
            <input
                type="text"
                name="titulo"
                class="form-control"
                placeholder="Título del ticket"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea
                name="descripcion"
                class="form-control"
                rows="4"
                placeholder="Describe el problema"
                required
            ></textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            Crear ticket
        </button>

        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
            Cancelar
        </a>
    </form>
</div>

</body>
</html>
