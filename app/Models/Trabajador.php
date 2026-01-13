<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Trabajador extends Authenticatable
{
    use Notifiable;

    protected $table = 'trabajadores';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}

