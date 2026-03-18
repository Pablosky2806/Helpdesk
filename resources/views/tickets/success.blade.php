<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Creado - HelpDesk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --primary-light: #eef2ff;
            --success: #16a34a;
            --sidebar-width: 250px;
            --topbar-height: 60px;
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

        .success-container {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            max-width: 600px;
            width: 100%;
            overflow: hidden;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .success-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }

        .success-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .success-header .ticket-id {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-top: 10px;
        }

        .success-body {
            padding: 40px;
        }

        .success-icon {
            font-size: 4rem;
            color: var(--success);
            text-align: center;
            margin-bottom: 30px;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .link-section {
            background: var(--primary-light);
            border-radius: 15px;
            padding: 25px;
            margin: 30px 0;
            border: 2px dashed var(--primary);
        }

        .link-label {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        .link-display {
            background: white;
            border: 2px solid var(--primary);
            border-radius: 10px;
            padding: 15px;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            word-break: break-all;
            margin-bottom: 15px;
            color: #1e293b;
        }

        .copy-button {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            font-size: 1rem;
        }

        .copy-button:hover {
            background: var(--primary-hover);
        }

        .copy-button.copied {
            background: var(--primary-hover);
        }

        .info-section {
            background: #f8fafc;
            border-radius: 15px;
            padding: 25px;
            margin-top: 30px;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .info-icon {
            color: var(--primary);
            margin-right: 15px;
            font-size: 1.2rem;
        }

        .info-text {
            color: #475569;
            line-height: 1.6;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-action {
            flex: 1;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
        }

        .btn-secondary {
            background: #64748b;
            color: white;
        }

        .btn-secondary:hover {
            background: #475569;
        }

        @media (max-width: 768px) {
            .success-header h1 {
                font-size: 2rem;
            }
            
            .success-body {
                padding: 25px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<div class="success-container">
    <!-- Header -->
    <div class="success-header">
        <h1>Ticket Creado</h1>
        <div class="ticket-id">Ticket #{{ $ticket->id }}</div>
    </div>

    <!-- Body -->
    <div class="success-body">
        <!-- Icono de éxito -->
        <div class="success-icon">
            <i class="bi bi-check-circle-fill"></i>
        </div>

        <!-- Enlace para compartir -->
        <div class="link-section">
            <div class="link-label">
                <i class="bi bi-link-45deg me-2"></i>
                Enlace para el Cliente
            </div>
            <div class="link-display" id="ticketLink">
                {{ url('/estado/' . $ticket->token_acceso) }}
            </div>
            <button class="copy-button" onclick="copyLink()">
                <i class="bi bi-clipboard me-2"></i>
                <span id="copyText">Copiar Enlace</span>
            </button>
        </div>

        <!-- Información -->
        <div class="info-section">
            <div class="info-item">
                <i class="bi bi-person info-icon"></i>
                <div class="info-text">
                    <strong>Cliente:</strong> {{ $ticket->nombre }} {{ $ticket->apellidos }}
                </div>
            </div>
            <div class="info-item">
                <i class="bi bi-envelope info-icon"></i>
                <div class="info-text">
                    <strong>Email:</strong> {{ $ticket->email }}
                </div>
            </div>
            <div class="info-item">
                <i class="bi bi-phone info-icon"></i>
                <div class="info-text">
                    <strong>Teléfono:</strong> {{ $ticket->telefono }}
                </div>
            </div>
            <div class="info-item">
                <i class="bi bi-clock-history info-icon"></i>
                <div class="info-text">
                    <strong>Actualización automática:</strong> El cliente verá los cambios en tiempo real cada 30 segundos
                </div>
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="action-buttons">
            <a href="{{ url('/estado/' . $ticket->token_acceso) }}" target="_blank" class="btn-action btn-primary">
                <i class="bi bi-eye me-2"></i>
                Ver Estado
            </a>
            <a href="{{ route('tickets.index') }}" class="btn-action btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Volver a Tickets
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function copyLink() {
    const linkElement = document.getElementById('ticketLink');
    const buttonElement = document.querySelector('.copy-button');
    const copyTextElement = document.getElementById('copyText');
    
    // Seleccionar y copiar el texto
    const textArea = document.createElement('textarea');
    textArea.value = linkElement.textContent;
    document.body.appendChild(textArea);
    textArea.select();
    document.execCommand('copy');
    document.body.removeChild(textArea);
    
    // Cambiar el botón temporalmente
    buttonElement.classList.add('copied');
    copyTextElement.innerHTML = '<i class="bi bi-check me-2"></i>¡Copiado!';
    
    // Restaurar el botón después de 3 segundos
    setTimeout(() => {
        buttonElement.classList.remove('copied');
        copyTextElement.innerHTML = '<i class="bi bi-clipboard me-2"></i>Copiar Enlace';
    }, 3000);
}

// Animación de entrada
document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.success-container');
});
</script>
</body>
</html>
