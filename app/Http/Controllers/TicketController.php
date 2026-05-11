<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Notifications\TicketCreado;
use App\Notifications\TicketEstadoActualizado;
use App\Notifications\TicketCerrado;
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

    $ticket = Ticket::create(array_merge(
        $request->all(),
        [
            'user_id' => auth()->id(),
            'estado' => 'abierto',
            'progreso' => 0,
        ]
    ));

    // Registrar creación en el historial
    $ticket->registrarCambio('creacion', 'abierto', 'Ticket creado por el usuario');

    // Enviar notificación por email al usuario (temporalmente desactivado)
    // $ticket->user->notify(new TicketCreado($ticket));

    // Redirigir a página de éxito con enlace para copiar
    return redirect()
        ->route('tickets.success', $ticket->id);
    }

    public function success(Ticket $ticket)
{
    // Seguridad: admin y tecnico pueden ver todos los tickets, usuarios solo sus propios tickets
    if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'tecnico' && $ticket->user_id !== auth()->id()) {
        abort(403);
    }

    return view('tickets.success', compact('ticket'));
}

    public function show(Ticket $ticket)
{
    // Seguridad: admin y tecnico pueden ver todos los tickets, usuarios solo sus propios tickets
    if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'tecnico' && $ticket->user_id !== auth()->id()) {
        abort(403);
    }

    return view('tickets.show', compact('ticket'));
}


    // Mostrar formulario de edición
public function edit(Ticket $ticket)
{
    // Seguridad: admin y tecnico pueden ver todos los tickets, usuarios solo sus propios tickets
    if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'tecnico' && $ticket->user_id !== auth()->id()) {
        abort(403);
    }

    return view('tickets.edit', compact('ticket'));
}

// Actualizar ticket
public function update(Request $request, Ticket $ticket)
{
    // Seguridad: admin y tecnico pueden editar todos los tickets, usuarios solo sus propios tickets
    if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'tecnico' && $ticket->user_id !== auth()->id()) {
        abort(403);
    }

    $request->validate([
        'titulo' => 'required|string|max:255',
        'descripcion' => 'required|string',
        'categoria' => 'required',
        'prioridad' => 'required',
        'progreso' => 'nullable|integer|min:0|max:100',
    ]);

    $estadoAnterior = $ticket->estado;
    $estadoNuevo = null;
    
    // Verificar si el estado cambió
    if ($request->has('estado')) {
        $estadoNuevo = $request->estado;
    }
    
    $ticket->update([
        'titulo' => $request->titulo,
        'descripcion' => $request->descripcion,
        'categoria' => $request->categoria,
        'prioridad' => $request->prioridad,
        'progreso' => $request->progreso ?? $ticket->progreso,
        'estado' => $estadoNuevo ?? $ticket->estado,
    ]);

    // Registrar actualización en el historial
    if ($estadoNuevo && $estadoNuevo !== $estadoAnterior) {
        $ticket->registrarCambio('cambio_estado', $estadoAnterior, "Ticket actualizado a {$estadoNuevo}");
    } else {
        $ticket->registrarCambio('actualizacion', null, 'Ticket actualizado por el usuario');
    }

    return redirect()
        ->route('tickets.index')
        ->with('success', 'Ticket actualizado correctamente');
}

    public function close(Ticket $ticket)
{
    // Seguridad: admin y tecnico pueden cerrar todos los tickets, usuarios solo sus propios tickets
    if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'tecnico' && $ticket->user_id !== auth()->id()) {
        abort(403);
    }

    $ticket->update([
        'estado' => 'cerrado'
    ]);

    // Registrar cierre en el historial
    $ticket->registrarCambio('cierre', 'cerrado', 'Ticket cerrado por el usuario');

    // Enviar notificación por email al correo del formulario
    $ticket->user->notify(new TicketCerrado($ticket));

    return redirect()
        ->route('tickets.index')
        ->with('success', 'Ticket cerrado correctamente');
}


}
