<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;

class FirebaseController extends Controller
{
    public function verify(Request $request)
    {
        try {
            $data = $request->validate([
                'uid' => 'required|string',
                'email' => 'required|email',
                'name' => 'required|string|max:255',
                'avatar' => 'nullable|url'
            ]);

            // Buscar usuario por UID de Firebase
            $user = User::where('firebase_uid', $data['uid'])->first();

            if ($user) {
                // Usuario existente, iniciar sesión
                Auth::login($user);
                return response()->json(['success' => true, 'message' => 'Usuario encontrado', 'redirect' => '/dashboard']);
            } else {
                // Buscar por email
                $existingUser = User::where('email', $data['email'])->first();
                
                if ($existingUser) {
                    // Asociar UID de Firebase al usuario existente
                    $existingUser->update(['firebase_uid' => $data['uid']]);
                    Auth::login($existingUser);
                    return response()->json(['success' => true, 'message' => 'Cuenta asociada con Google', 'redirect' => '/dashboard']);
                } else {
                    // Crear nuevo usuario
                    $newUser = User::create([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'firebase_uid' => $data['uid'],
                        'avatar' => $data['avatar'] ?? null,
                        'password' => bcrypt(Str::random(32)), // Contraseña aleatoria
                        'email_verified_at' => now(),
                        'role' => 'user' // Rol por defecto
                    ]);

                    Auth::login($newUser);
                    return response()->json(['success' => true, 'message' => 'Usuario creado exitosamente', 'redirect' => '/dashboard']);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
