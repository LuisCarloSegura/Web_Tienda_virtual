<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EsAdministrador
{
    /**
     * Deja pasar solo a usuarios con rol = 'administrador'.
     * Si no está logueado o es 'cliente', le bloquea el acceso.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || $request->user()->rol !== 'administrador') {
            abort(403, 'No tenés permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}