<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;

class FirebaseAuthController extends Controller
{
    public function verify(Request $request, FirebaseAuth $firebaseAuth)
{
    $idToken = $request->token;

    try {
        // 1️⃣ Verificar token con Firebase
        $verifiedIdToken = $firebaseAuth->verifyIdToken($idToken);

        $uid = $verifiedIdToken->claims()->get('sub');
        $email = $verifiedIdToken->claims()->get('email');
        $name = $verifiedIdToken->claims()->get('name') ?? $email;

        // 2️⃣ Buscar usuario por firebase_uid (NO por email)
        $user = User::updateOrCreate(
            ['firebase_uid' => $uid], // 🔥 CLAVE PRINCIPAL
            [
                'name' => $name,
                'email' => $email,
                'password' => bcrypt(uniqid()) // solo por compatibilidad
            ]
        );

        // 3️⃣ Iniciar sesión en Laravel
        Auth::login($user);

        return response()->json([
            'success' => true
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 401);
    }
}
}