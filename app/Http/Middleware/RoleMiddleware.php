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

        // Separar roles por coma si hay múltiples
        $roles = explode(',', $role);
        $hasRole = false;

        // Verificar si el usuario tiene alguno de los roles requeridos
        foreach ($roles as $requiredRole) {
            switch (trim($requiredRole)) {
                case 'admin':
                    if ($user->isAdmin() || $user->isTecnico()) {
                        $hasRole = true;
                    }
                    break;
                case 'tecnico':
                    if ($user->isAdmin() || $user->isTecnico()) {
                        $hasRole = true;
                    }
                    break;
                case 'user':
                    if ($user->isUser()) {
                        $hasRole = true;
                    }
                    break;
            }
        }

        if (!$hasRole) {
            abort(403, 'Acceso denegado: Se requiere rol específico');
        }

        return $next($request);
    }
}
