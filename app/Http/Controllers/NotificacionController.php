<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    public function store(Request $request) {
        Notificacion::create([
            'tipo' => $request['tipo'],
            'mensaje' => $request['mensaje'],
            
        ]);
    }

    public function index() {
        $noti = Notificacion::all();

        return response()->json($noti);
    }
}
