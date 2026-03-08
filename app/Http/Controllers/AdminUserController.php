<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        // Obtener todos los usuarios menos a mi mismo (opcional)
        $users = User::orderBy('name')->get();
        return view('admin.users', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,tecnico,user'
        ]);

        $user->update([
            'role' => $request->role
        ]);

        return redirect()->back()->with('success', 'Rol actualizado correctamente para ' . $user->name);
    }
}
