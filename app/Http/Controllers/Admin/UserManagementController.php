<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with('rol')->orderBy('name')->paginate(15);

        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('id')->get();

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'dni' => ['nullable', 'string', 'max:20', Rule::unique('users', 'dni')->ignore($user->id)],
            'rol_id' => ['required', 'integer', 'exists:roles,id'],
            'estado_aprobacion' => ['required', 'string', 'max:50'],
            'activo' => ['required', 'boolean'],
        ]);

        $antes = $user->only(['name', 'email', 'dni', 'rol_id', 'estado_aprobacion', 'activo']);

        $user->update($validated);

        $despues = $user->fresh()->only(['name', 'email', 'dni', 'rol_id', 'estado_aprobacion', 'activo']);
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
            $admin = auth()->user();

            Log::info('Auditoría de perfil de usuario actualizada', [
                'admin_id' => $admin?->id,
                'admin_name' => $admin?->name,
                'target_user_id' => $user->id,
                'target_user_name' => $user->name,
                'cambios' => $cambios,
            ]);
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Perfil y permisos del usuario actualizados correctamente.');
    }
}