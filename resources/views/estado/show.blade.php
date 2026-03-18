<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado del Ticket #{{ $ticket->id }} - HelpDesk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --primary-light: #eef2ff;
            --success: #16a34a;
            --warning: #d97706;
            --danger: #dc2626;
        }
        * { font-family: 'Instrument Sans', system-ui, sans-serif; }
        body { 
            margin: 0; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .estado-container {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            max-width: 800px;
            width: 100%;
            overflow: hidden;
        }

        .estado-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .estado-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .estado-header .ticket-id {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-top: 10px;
        }

        .estado-body {
            padding: 40px;
        }

        .estado-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 25px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .estado-badge.abierto {
            background: var(--primary);
            color: white;
        }

        .estado-badge.en_proceso {
            background: var(--warning);
            color: white;
        }

        .estado-badge.cerrado {
            background: var(--success);
            color: white;
        }

        .estado-icon {
            font-size: 1.5rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .info-card {
            background: #f8fafc;
            border-radius: 15px;
            padding: 25px;
            border-left: 4px solid var(--primary);
            transition: transform 0.3s ease;
        }

        .info-card:hover {
            transform: none;
        }

        .info-label {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 500;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-size: 1.1rem;
            color: #1e293b;
            font-weight: 600;
        }

        .progreso-section {
            margin-top: 30px;
            padding: 25px;
            background: linear-gradient(135deg, var(--primary-light) 0%, #fff 100%);
            border-radius: 15px;
            border: 1px solid rgba(79, 70, 229, 0.1);
        }

        .progreso-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .progreso-bar {
            height: 20px;
            background: #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .progreso-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-hover) 100%);
            border-radius: 10px;
            transition: width 1s ease;
            position: relative;
            overflow: hidden;
        }

        .estado-footer {
            text-align: center;
            padding: 30px;
            background: #f8fafc;
            border-top: 1px solid #e5e7eb;
        }

        .estado-footer p {
            color: #64748b;
            margin: 0;
            font-size: 0.9rem;
        }

        .refresh-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .refresh-btn:hover {
            background: var(--primary-hover);
        }

        @media (max-width: 768px) {
            .estado-header h1 {
                font-size: 2rem;
            }
            
            .estado-body {
                padding: 25px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div class="estado-container">
    <!-- Header -->
    <div class="estado-header">
        <h1>HelpDesk</h1>
        <div class="ticket-id">Ticket #{{ $ticket->id }}</div>
    </div>

    <!-- Body -->
    <div class="estado-body">
        <!-- Estado Principal -->
        <div class="text-center">
            <div class="estado-badge {{ $ticket->estado }}">
                <i class="bi {{ match($ticket->estado) {
                    'abierto' => 'bi-envelope-open',
                    'en_proceso' => 'bi-gear',
                    'cerrado' => 'bi-check-circle',
                    default => 'bi-question-circle'
                } }} estado-icon"></i>
                {{ $ticket->estado_formateado }}
            </div>
        </div>

        <!-- Información del Ticket -->
        <div class="info-grid">
            <div class="info-card">
                <div class="info-label">Título</div>
                <div class="info-value">{{ $ticket->titulo }}</div>
            </div>
            <div class="info-card">
                <div class="info-label">Prioridad</div>
                <div class="info-value">{{ $ticket->prioridad_formateada }}</div>
            </div>
            <div class="info-card">
                <div class="info-label">Categoría</div>
                <div class="info-value">{{ ucfirst(str_replace('_', ' ', $ticket->categoria)) }}</div>
            </div>
            <div class="info-card">
                <div class="info-label">Cliente</div>
                <div class="info-value">{{ $ticket->nombre }} {{ $ticket->apellidos }}</div>
            </div>
        </div>

        <!-- Progreso -->
        <div class="progreso-section">
            <div class="progreso-header">
                <div class="info-label mb-0">Progreso de Reparación</div>
                <div class="info-value mb-0">{{ $ticket->progreso }}%</div>
            </div>
            <div class="progreso-bar">
                <div class="progreso-fill" style="width: {{ $ticket->progreso }}%"></div>
            </div>
        </div>

        <!-- Descripción -->
        <div class="info-card" style="margin-top: 20px;">
            <div class="info-label">Descripción del Problema</div>
            <div class="info-value" style="font-weight: 400; line-height: 1.6;">
                {{ $ticket->descripcion }}
            </div>
        </div>

        <!-- Tiempos -->
        <div class="info-grid" style="margin-top: 20px;">
            <div class="info-card">
                <div class="info-label">Fecha de Creación</div>
                <div class="info-value">{{ $ticket->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <div class="info-card">
                <div class="info-label">Última Actualización</div>
                <div class="info-value">{{ $ticket->updated_at->format('d/m/Y H:i') }}</div>
            </div>
            @if($ticket->estado === 'cerrado')
                <div class="info-card">
                    <div class="info-label">Tiempo de Resolución</div>
                    <div class="info-value">{{ $ticket->tiempo_resolucion }}</div>
                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <div class="estado-footer">
        <p>
            <i class="bi bi-info-circle me-2"></i>
            Esta página muestra el estado actual de tu ticket. Actualiza automáticamente.
        </p>
        <button class="refresh-btn" onclick="location.reload()">
            <i class="bi bi-arrow-clockwise me-2"></i>
            Actualizar Estado
        </button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Auto-refresh cada 30 segundos
    setInterval(() => {
        location.reload();
    }, 30000);

    // Animación de progreso al cargar
    window.addEventListener('load', () => {
        const progresoFill = document.querySelector('.progreso-fill');
    });
</script>
</body>
</html>
