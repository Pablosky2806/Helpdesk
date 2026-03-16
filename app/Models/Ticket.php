<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre',
        'apellidos',
        'email',
        'telefono',
        'empresa',
        'tipo_dispositivo',
        'marca',
        'modelo',
        'numero_serie',
        'titulo',
        'descripcion',
        'categoria',
        'prioridad',
        'estado',
        'progreso',
    ];

    // Relación con el usuario que creó el ticket
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el historial de cambios
    public function historial()
    {
        return $this->hasMany(TicketHistorial::class)->orderBy('created_at', 'desc');
    }

    // Relación con los cambios de estado específicamente
    public function cambiosEstado()
    {
        return $this->hasMany(TicketHistorial::class)
                   ->where('accion', 'cambio_estado')
                   ->orderBy('created_at', 'desc');
    }

    // Método para registrar cambio en el historial
    public function registrarCambio($accion, $estadoNuevo = null, $comentarios = null, $userId = null)
    {
        $estadoAnterior = $this->getOriginal('estado');
        
        return $this->historial()->create([
            'user_id' => $userId ?? auth()->id(),
            'estado_anterior' => $estadoAnterior,
            'estado_nuevo' => $estadoNuevo ?? $this->estado,
            'comentarios' => $comentarios,
            'accion' => $accion,
        ]);
    }

    // Sobrescribir el método save para registrar cambios automáticamente
    public function save(array $options = [])
    {
        $estadoOriginal = $this->getOriginal('estado');
        $saved = parent::save($options);
        
        if ($saved && $this->wasChanged('estado') && $estadoOriginal !== $this->estado) {
            $this->registrarCambio('cambio_estado', $this->estado, 'Cambio de estado automático');
        }
        
        return $saved;
    }

    // Accesor para obtener el estado formateado
    public function getEstadoFormateadoAttribute()
    {
        return match($this->estado) {
            'abierto' => '🔴 Abierto',
            'en_proceso' => '🟡 En Proceso',
            'cerrado' => '🟢 Cerrado',
            default => $this->estado,
        };
    }

    // Accesor para obtener la prioridad formateada
    public function getPrioridadFormateadaAttribute()
    {
        return match($this->prioridad) {
            'baja' => '🟢 Baja',
            'media' => '🟡 Media',
            'alta' => '🔴 Alta',
            default => $this->prioridad,
        };
    }

    // Método para obtener tiempo de resolución
    public function getTiempoResolucionAttribute()
    {
        if ($this->estado === 'cerrado') {
            return $this->created_at->diffForHumans($this->updated_at);
        }
        return 'No cerrado';
    }
}
