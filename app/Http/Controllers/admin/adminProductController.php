<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\producto;
use Illuminate\Http\Request;

class adminProductController extends Controller
{
    public function index() {
        return view('admin.product.manage');
    }
    public function review() {
        $productos = producto::all();
        return view('admin.product.manage_product_review', compact('productos'));
    }
    public function pageEdit(Request $request) {
        $editProduct = producto::where('id', $request->id)->first();
        return view("admin.product.edit_product", compact('editProduct'));
    }
    public function editProduct(Request $request) {

        producto::where('id', $request->id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $request->image,
            'stock' => $request->stock,
            'category' => $request->category, 
        ]);
        return redirect()->route('product.review')->with('success', 'producto actualizado con exito');
        
    }
    public function storeProduct(Request $request) {

        $request->validate( [
            'name'=> 'required|string',
            'description' => 'required',
            'price' => 'required|integer',
            'image' => 'required|string',
            'stock' => 'required|integer',
            'category' => 'required'

        ]);

        producto::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $request->image,
            'stock' => $request->stock,
            'category' => $request->category, 
        ]);

        return redirect()->back()->with('success', 'producto subido con exito');
    }

    public function eliminarProducto(Request $request) {

        producto::where('id', $request->id)->delete();

        return redirect()->back()->with('success', 'producto eliminado con exito');

    }
   
}
