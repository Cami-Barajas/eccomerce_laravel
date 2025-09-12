<?php

namespace App\Http\Controllers;

use App\Models\detalle_pedido;
use App\Models\pedido;
use App\Models\producto;
use Illuminate\Http\Request;

class PedidosController extends Controller
{
    public function store(Request $request) {

        foreach($request->pedido as $pedido) {

           $nuevoPedido = pedido::create( [
                'id_usuario' => $pedido['usuarioId'],
                'id_direccion' => $pedido['direccionId'],
                'fecha' => NOW()

            ]);

            $pedidoId = $nuevoPedido->id_pedido;

            foreach($pedido['compras'] as $producto) {

                detalle_pedido::create([
                    'id_pedido' => $pedidoId,
                    'id_producto' => $producto['id'],
                    'cantidad' => $producto['contador'],
                    'precio_unitario' => $producto['price']
                ]);

                producto::where('id', $producto['id'])->update([
                    'stock' => $producto['stock'],
                ]);


            }
        }
    }
}


