<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class ProfileController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id')->get();

        return view('profiles.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:150'],
            'dni'      => ['required', 'string', 'min:8', 'max:15', 'unique:users,dni'],
            'rol_id'   => ['required', 'integer', 'in:1,2,3,4,5,6'],
            'password' => ['nullable', 'string', 'min:6', 'max:100'],
        ], [
            'name.required'   => 'El nombre del usuario es obligatorio.',
            'dni.required'    => 'El DNI es obligatorio.',
            'dni.unique'      => 'Ya existe un usuario registrado con ese DNI.',
            'rol_id.required' => 'Debe seleccionar un rol.',
            'password.min'    => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        $rolId = (int) $validated['rol_id'];
        $cleanDni = trim($validated['dni']);
        $rawPassword = !empty($validated['password']) ? $validated['password'] : $cleanDni;

        $permissionsByRole = match ($rolId) {
            1 => ['inventory', 'library', 'tic', 'aip', 'laboratory'],
            2 => ['library'],
            3 => ['inventory'],
            4 => ['tic'],
            5 => ['aip'],
            6 => ['laboratory'],
            default => [],
        };

        $roleSlug = match ($rolId) {
            1 => 'admin',
            2 => 'library',
            3 => 'inventory',
            4 => 'tic',
            5 => 'aip',
            6 => 'laboratory',
            default => 'user',
        };

        $userData = [
            'name'        => trim($validated['name']),
            'dni'         => $cleanDni,
            'rol_id'      => $rolId,
            'permissions' => $permissionsByRole,
            'password'    => Hash::make($rawPassword),
        ];

        if (Schema::hasColumn('users', 'role')) {
            $userData['role'] = $roleSlug;
        }

        if (Schema::hasColumn('users', 'email')) {
            $userData['email'] = $cleanDni . '@ietungasuca.edu.pe';
        }

        User::create($userData);

        return redirect()
            ->route('profiles.index')
            ->with('success', 'Usuario creado correctamente y permisos asignados a su módulo correspondiente.');
    }

    public function updateAccess(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'rol_id'        => ['required', 'integer', 'in:1,2,3,4,5,6'],
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['string', 'in:inventory,library,tic,aip,laboratory'],
        ]);

        $user->rol_id = (int) $validated['rol_id'];
        $user->permissions = $validated['permissions'] ?? [];
        $user->save();

        return redirect()
            ->route('profiles.index')
            ->with('success', "Accesos actualizados para {$user->name}.");
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (Auth::check() && (int) Auth::id() === (int) $user->id) {
            return redirect()
                ->route('profiles.index')
                ->withErrors(['delete' => 'No puedes eliminar tu propio usuario mientras tienes la sesión activa.']);
        }

        $nombre = $user->name;
        $user->delete();

        return redirect()
            ->route('profiles.index')
            ->with('success', "Usuario {$nombre} eliminado correctamente.");
    }
}