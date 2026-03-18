<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class EstadoTicketController extends Controller
{
    /**
     * Mostrar el estado del ticket de forma pública
     */
    public function show($token)
    {
        $ticket = Ticket::where('token_acceso', $token)->firstOrFail();
        
        return view('estado.show', compact('ticket'));
    }
}
