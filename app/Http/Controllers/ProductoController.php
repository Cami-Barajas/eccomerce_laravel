<?php

namespace App\Http\Controllers;

use App\Models\producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index() {

        $productos = producto::all();

        return response()->json($productos);
    }

   
}
?>
