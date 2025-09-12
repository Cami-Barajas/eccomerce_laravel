<?php

namespace App\Http\Controllers;

use App\Models\direccion;
use Illuminate\Http\Request;

class DireccionController extends Controller
{
    public function obtenerId() {

        $id_usuario = session('id_usuario');

        $result = direccion::where('id_usuario', $id_usuario)->first();

        if(!$result) {
            return response()->json(['nuevo' => $id_usuario]);
        };
            return response()->json(
                [
                "id_direccion" => $result['id_direccion'],
                "id_usuario" => $result['id_usuario'],
                "pais" => (int) $result['pais_code'],
                "provincia" => (int) $result['provincia_code'],
                "nombre" => $result['nombre_completo'],
                "email" => $result['email'],
                "numero" => $result['numero_telefono'],
                "calle" => $result['nombre_calle'],
                "complement" => $result['complemento'],
                "ciudad" => (int) $result['ciudad_code'],
                "postal" =>(int) $result['codigo_postal'],
                ]
                );
    }

    public function store(Request $request) {
        try{
        foreach($request->address as $datos) {
            direccion::create([
                'id_usuario' => $datos['id_usuario'],
                'pais_code' => $datos['country'],
                'pais' => $datos['country_name'],
                'nombre_completo' => $datos['name'],
                'email' => $datos['email'],
                'numero_telefono' => $datos['numberPhone'],
                'nombre_calle' => $datos['addressLine'],
                'complemento' => $datos['apto'],
                'provincia_code' => $datos['department'],
                'provincia' => $datos['department_name'],
                'ciudad_code' => $datos['city'],
                'ciudad' => $datos['city_name'],
                'codigo_postal' =>$datos['postalCode'],
                
            ]);
        }
        return response()->json(['respuesta' => 'Actualización exitosa']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
    }

    public function update(Request $request) {
try{
        foreach($request->address as $datos) {

            direccion::where('id_direccion', $datos['id'])->update([
                'pais_code' => $datos['country'],
                'pais' => $datos['country_name'],
                'nombre_completo' => $datos['name'],
                'email' => $datos['email'],
                'numero_telefono' => $datos['numberPhone'],
                'nombre_calle' => $datos['addressLine'],
                'complemento' => $datos['apto'],
                'provincia_code' => $datos['department'],
                'provincia' => $datos['department_name'],
                'ciudad_code' => $datos['city'],
                'ciudad' => $datos['city_name'],
                'codigo_postal' =>$datos['postalCode'],
            ]);
        }
        return response()->json(['respuesta' => 'Actualización exitosa']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
}
