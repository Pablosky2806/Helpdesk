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

    public function store(Request $request)
    {
        Ticket::create([
            'user_id' => auth()->id(),
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'estado' => 'abierto',
        ]);

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket creado correctamente');
    }
}
