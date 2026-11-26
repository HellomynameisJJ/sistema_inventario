<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    private const ROLES = [
        1 => ['slug' => 'admin', 'label' => 'Administrador / Directiva'],
        2 => ['slug' => 'bibliotecario', 'label' => 'Encargado de Biblioteca'],
        3 => ['slug' => 'mobiliario', 'label' => 'Encargado de Mobiliario'],
        4 => ['slug' => 'tic', 'label' => 'Encargado de Equipos TIC'],
        5 => ['slug' => 'aip', 'label' => 'Encargado de Aula AIP'],
        6 => ['slug' => 'laboratorio', 'label' => 'Encargado de Laboratorio'],
    ];

    private const ALLOWED_MODULES = [
        'inventory',
        'library',
        'tic',
        'aip',
        'laboratory',
    ];

    private function ensureAdmin(): User
    {
        $currentUser = auth()->user();

        if (!$currentUser || (int) $currentUser->rol_id !== 1) {
            abort(403, 'Acceso denegado. Solo el administrador puede gestionar perfiles.');
        }

        return $currentUser;
    }

    public function index()
    {
        $this->ensureAdmin();

        $users = User::orderBy('id')->paginate(15);
        $roles = self::ROLES;

        return view('profiles.index', compact('users', 'roles'));
    }

    public function edit($id)
    {
        $this->ensureAdmin();

        $targetUser = User::findOrFail($id);
        $roles = self::ROLES;

        return view('profiles.edit', compact('targetUser', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $admin = $this->ensureAdmin();
        $targetUser = User::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'dni' => ['required', 'string', 'size:8', Rule::unique('users', 'dni')->ignore($targetUser->id)],
            'rol_id' => ['required', 'integer', Rule::in(array_keys(self::ROLES))],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', Rule::in(self::ALLOWED_MODULES)],
        ]);

        $rolId = (int) $validated['rol_id'];
        $rolSlug = self::ROLES[$rolId]['slug'] ?? $targetUser->role;
        $perms = array_values(array_unique($validated['permissions'] ?? []));

        $antes = $targetUser->only(['name', 'dni', 'rol_id', 'role', 'permissions']);

        $targetUser->update([
            'name' => $validated['name'],
            'dni' => $validated['dni'],
            'rol_id' => $rolId,
            'role' => $rolSlug,
            'permissions' => $perms,
        ]);

        $despues = $targetUser->fresh()->only(['name', 'dni', 'rol_id', 'role', 'permissions']);
        $cambios = [];

        foreach ($despues as $campo => $valorNuevo) {
            if (($antes[$campo] ?? null) !== $valorNuevo) {
                $cambios[$campo] = [
                    'antes' => $antes[$campo] ?? null,
                    'despues' => $valorNuevo,
                ];
            }
        }

        if (!empty($cambios)) {
            Log::info('Auditoría: perfil de usuario modificado por administrador', [
                'admin_id' => $admin->id,
                'admin_name' => $admin->name,
                'target_user_id' => $targetUser->id,
                'target_user_name' => $targetUser->name,
                'cambios' => $cambios,
            ]);
        }

        return redirect()
            ->route('profiles.index')
            ->with('success', 'Perfil actualizado correctamente para ' . $targetUser->name . '.');
    }

    public function updateAccess(Request $request, $id)
    {
        $admin = $this->ensureAdmin();
        $targetUser = User::findOrFail($id);

        $validated = $request->validate([
            'rol_id' => ['required', 'integer', Rule::in(array_keys(self::ROLES))],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', Rule::in(self::ALLOWED_MODULES)],
        ]);

        $rolId = (int) $validated['rol_id'];
        $rolSlug = self::ROLES[$rolId]['slug'] ?? $targetUser->role;
        $perms = array_values(array_unique($validated['permissions'] ?? []));

        $antes = $targetUser->only(['rol_id', 'role', 'permissions']);

        $targetUser->update([
            'rol_id' => $rolId,
            'role' => $rolSlug,
            'permissions' => $perms,
        ]);

        $despues = $targetUser->fresh()->only(['rol_id', 'role', 'permissions']);

        Log::info('Auditoría: accesos y rol actualizados por administrador', [
            'admin_id' => $admin->id,
            'admin_name' => $admin->name,
            'target_user_id' => $targetUser->id,
            'target_user_name' => $targetUser->name,
            'antes' => $antes,
            'despues' => $despues,
        ]);

        return redirect()
            ->route('profiles.index')
            ->with('success', 'Accesos y rol actualizados correctamente para ' . $targetUser->name . '.');
    }
}