<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TecnicoController extends Controller
{
    public function dashboard()
    {
        $tickets = \App\Models\Ticket::where('estado', '!=', 'cerrado')->orderBy('created_at', 'desc')->get();
        return view('tecnico.dashboard', compact('tickets'));
    }
}
