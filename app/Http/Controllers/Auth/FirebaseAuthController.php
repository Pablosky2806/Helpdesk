<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Facades\Log;

class FirebaseAuthController extends Controller
{
    public function verifyToken(Request $request)
    {
        $idToken = $request->input('idToken');

        if (!$idToken) {
            return response()->json(['message' => 'Token no proporcionado'], 400);
        }

        try {
            // Utilizamos el Facade para obtener la instancia de Firebase Auth
            $auth = Firebase::auth();
            $verifiedIdToken = $auth->verifyIdToken($idToken);
            
            // uid proveniente de Firebase
            $uid = $verifiedIdToken->claims()->get('sub');
            
            // Extraer email y nombre de las propiedades del token
            $email = $verifiedIdToken->claims()->get('email');
            $name = $verifiedIdToken->claims()->get('name') ?? 'Usuario de Google';

            // Buscar si ya existe el usuario por UID o por Email
            $user = User::where('firebase_uid', $uid)->orWhere('email', $email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'firebase_uid' => $uid,
                    'password' => null, // Contraseña nula porque entra por Google
                ]);
            } else {
                // Si el usuario existe por email pero no tiene su UID de Firebase guardado, lo actualizamos.
                if (!$user->firebase_uid) {
                    $user->firebase_uid = $uid;
                    $user->save();
                }
            }

            // Iniciar sesión en Laravel
            Auth::login($user, true); // true para "remember me"

            // Devolver URL a donde debe redirigir
            return response()->json([
                'success' => true,
                'redirect' => route('dashboard')
            ]);
            
        } catch (\Kreait\Firebase\Exception\Auth\FailedToVerifyToken $e) {
            Log::error('Error verificando ID Token de Firebase: ' . $e->getMessage());
            return response()->json(['message' => 'El token es inválido o ha expirado.'], 401);
        } catch (\Exception $e) {
            Log::error('Excepción al autenticar con Firebase: ' . $e->getMessage());
            return response()->json(['message' => 'Ocurrió un error en el servidor.'], 500);
        }
    }
}
