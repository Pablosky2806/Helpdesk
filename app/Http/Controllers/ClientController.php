<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function dashboard()
    {
        $tickets = \App\Models\Ticket::where('user_id', auth()->id())->get();
        return view('client.dashboard', compact('tickets'));
    }
}
