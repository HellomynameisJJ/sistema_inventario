<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'avatar',
        'email',
        'password',
        'dni',
        'rol_id',
        'role',
        'permissions',
        'estado_aprobacion',
        'activo',
        'theme',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean',
            'permissions' => 'array',
        ];
    }

    /**
     * Relación con la tabla de roles.
     */
    public function rol()
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }

    /**
     * Devuelve la etiqueta legible del rol institucional.
     */
    public function getRoleLabel(): string
    {
        $labels = [
            1 => 'Administrador / Directiva',
            2 => 'Encargado de Biblioteca',
            3 => 'Encargado de Mobiliario',
            4 => 'Encargado de Equipos TIC',
            5 => 'Encargado de Aula AIP',
            6 => 'Encargado de Laboratorio',
        ];

        $rolId = (int) ($this->rol_id ?? 0);

        if (isset($labels[$rolId])) {
            return $labels[$rolId];
        }

        if (!empty($this->role)) {
            return ucfirst((string) $this->role);
        }

        return 'Usuario Institucional';
    }

    /**
     * Devuelve la lista normalizada de permisos del usuario.
     *
     * @return array<int, string>
     */
    public function getPermissionsList(): array
    {
        $raw = $this->permissions;

        if (is_array($raw)) {
            return $raw;
        }

        if (is_string($raw) && $raw !== '') {
            $decoded = json_decode($raw, true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }

        return [];
    }

    /**
     * Verifica si el usuario tiene acceso a un módulo institucional.
     */
    public function hasModulePermission(string $module): bool
    {
        if ((int) $this->rol_id === 1 || in_array($this->role, ['admin', 'directiva'], true)) {
            return true;
        }

        return in_array($module, $this->getPermissionsList(), true);
    }
}