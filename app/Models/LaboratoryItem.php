<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaboratoryItem extends Model
{
    use HasFactory;

    protected $table = 'laboratory_items';

    protected $fillable = [
        'item',
        'codigo_interno',
        'denominacion_tecnica',
        'descripcion_tecnica',
        'cantidad',
    ];
}