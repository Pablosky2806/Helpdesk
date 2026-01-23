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
    ];
}
