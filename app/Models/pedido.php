<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pedido extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id_pedido';                                              

    protected $fillable = ['id_usuario', 'id_direccion', 'fecha'];

    public $timestamps = false;

}

class detalle_pedido extends Model {

protected $table = 'detalle_pedido';

protected $fillable = ['id_pedido', 'id_producto', 'cantidad', 'precio_unitario'];

public $timestamps = false;
}
