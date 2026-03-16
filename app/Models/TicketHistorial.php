<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketHistorial extends Model
{
    use HasFactory;

    protected $table = 'ticket_historials';

    protected $fillable = [
        'ticket_id',
        'user_id',
        'estado_anterior',
        'estado_nuevo',
        'comentarios',
        'accion',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relación con el ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    // Relación con el usuario que realizó el cambio
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope para filtrar por tipo de acción
    public function scopePorAccion($query, $accion)
    {
        return $query->where('accion', $accion);
    }

    // Scope para obtener cambios de estado
    public function scopeCambiosEstado($query)
    {
        return $query->where('accion', 'cambio_estado');
    }

    // Scope para obtener los más recientes
    public function scopeRecientes($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Accesor para formatear la fecha
    public function getFechaFormateadaAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    // Accesor para obtener el nombre del usuario
    public function getNombreUsuarioAttribute()
    {
        return $this->user ? $this->user->name : 'Sistema';
    }
}
