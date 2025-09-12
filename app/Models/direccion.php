<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class direccion extends Model
{
    protected $table = 'direccion_envio';

    protected $fillable = [
        'id_usuario',
        'pais',
        'pais_code',
        'provincia',
        'provincia_code',
        'nombre_completo',
        'email',
        'numero_telefono',
        'nombre_calle',
        'complemento',
        'ciudad',
        'ciudad_code',
        'codigo_postal',
    ];
    public $timestamps = false;

    //manipular datos
}
