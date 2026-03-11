<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            abort(401, 'No autenticado');
        }

        $user = auth()->user();

        // Verificar si el usuario tiene el rol requerido
        switch ($role) {
            case 'admin':
                if (!$user->isAdmin()) {
                    abort(403, 'Acceso denegado: Se requiere rol de administrador');
                }
                break;
            case 'tecnico':
                if (!$user->isTecnico() && !$user->isAdmin()) {
                    abort(403, 'Acceso denegado: Se requiere rol de técnico');
                }
                break;
            case 'user':
                if (!$user->isUser()) {
                    abort(403, 'Acceso denegado: Se requiere rol de usuario');
                }
                break;
        }

        return $next($request);
    }
}
