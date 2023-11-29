<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $table = 'addresses';

    protected $fillable = [
        'user_id',
        'nombre',
        'apellidos',
        'calle',
        'numero_exterior',
        'numero_interior',
        'referencias',
        'colonia',
        'codigo_postal',
        'delegacion_municipal',
        'estado',
        'telefono',
    ];

}
