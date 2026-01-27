<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;


class TicketController extends Controller
{
    //Mostrar listado de tickets del usuario logueado
    public function index()
    {
        $tickets = Ticket::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('tickets.create');
    }
    //Guardar ticket
    // Guardar ticket
    public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'email' => 'required|email',
        'telefono' => 'nullable|string',
        'empresa' => 'nullable|string',

        'tipo_dispositivo' => 'required|string',
        'marca' => 'required|string',
        'modelo' => 'required|string',
        'numero_serie' => 'nullable|string',

        'titulo' => 'required|string|max:255',
        'descripcion' => 'required|string',
        'categoria' => 'required|in:software,hardware,red,soporte_tecnico',
        'prioridad' => 'required|in:baja,media,alta',
    ]);

    Ticket::create(array_merge(
        $request->all(),
        [
            'user_id' => auth()->id(),
            'estado' => 'abierto',
        ]
    ));

    return redirect()
        ->route('tickets.index')
        ->with('success', 'Ticket creado correctamente');
}

}
