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

    <h5 class="mt-4">Datos del cliente</h5>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Apellidos</label>
            <input type="text" name="apellidos" class="form-control" required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control">
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Empresa</label>
        <input type="text" name="empresa" class="form-control">
    </div>

    <h5 class="mt-4">Dispositivo</h5>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Tipo</label>
            <input type="text" name="tipo_dispositivo" class="form-control" required>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Marca</label>
            <input type="text" name="marca" class="form-control" required>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Modelo</label>
            <input type="text" name="modelo" class="form-control" required>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Número de serie</label>
        <input type="text" name="numero_serie" class="form-control">
    </div>

    <h5 class="mt-4">Información del ticket</h5>

    <div class="mb-3">
        <label class="form-label">Título</label>
        <input type="text" name="titulo" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Descripción</label>
        <textarea name="descripcion" class="form-control" rows="4" required></textarea>
    </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Categoría</label>
                <select name="categoria" class="form-select" required>
                    <option value="software">Software</option>
                    <option value="hardware">Hardware</option>
                    <option value="red">Red</option>
                    <option value="soporte_tecnico">Soporte técnico</option>
                </select>
        </div>


        <div class="col-md-6 mb-3">
            <label class="form-label">Prioridad</label>
            <select name="prioridad" class="form-select" required>
                <option value="baja">Baja</option>
                <option value="media" selected>Media</option>
                <option value="alta">Alta</option>
            </select>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Crear ticket</button>
    <a href="{{ route('tickets.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
</form>
</div>

</body>
</html>
