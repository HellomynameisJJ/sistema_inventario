<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles'; // Asegúrate de que coincida con el nombre de tu tabla en PostgreSQL

    protected $fillable = [
        'nombre_rol',
    ];

    // Relación inversa: Un rol pertenece a muchos usuarios
    public function users()
    {
        return $this->hasMany(User::class, 'rol_id');
    }
}