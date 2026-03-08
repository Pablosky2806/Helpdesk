<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $tickets = \App\Models\Ticket::all();
        return view('admin.dashboard', compact('tickets'));
    }
}
