<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckModuleAccess
{
    public function handle(Request $request, Closure $next, $module)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (method_exists($user, 'hasModulePermission') && $user->hasModulePermission((string) $module)) {
            return $next($request);
        }

        $roleByModule = [
            'library'    => 2,
            'inventory'  => 3,
            'tic'        => 4,
            'aip'        => 5,
            'laboratory' => 6,
        ];

        $rolId = (int) ($user->rol_id ?? 0);
        if ($rolId === 1 || (isset($roleByModule[$module]) && $rolId === $roleByModule[$module])) {
            return $next($request);
        }

        abort(403, 'No tienes autorización para acceder al módulo de ' . strtoupper((string) $module) . '.');
    }
}