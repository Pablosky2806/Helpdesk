<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminUserController extends Controller
{
    public function create()
    {
        return view('admin.users.create');
    }   

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function index()
    {
        // Obtener todos los usuarios menos a mi mismo (opcional)
        $users = User::orderBy('name')->get();
        return view('admin.users', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,tecnico,user'
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Usuario creado correctamente',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            Log::error('Error creando usuario: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al crear usuario'
            ], 500);
        }
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,tecnico,user'
        ]);

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Usuario actualizado correctamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error actualizando usuario: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar usuario'
            ], 500);
        }
    }

    public function destroy(User $user)
    {
        try {
            $userName = $user->name;
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Usuario eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error eliminando usuario: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar usuario'
            ], 500);
        }
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
