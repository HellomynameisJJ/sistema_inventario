<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibraryItem extends Model
{
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'quantity',
        'status',
        'identificador',
        'denominacion',
        'coleccion',
        'autor',
        'editorial',
        'anio_edicion',
        'cantidad',
        'estado',
        'observaciones',
    ];
}