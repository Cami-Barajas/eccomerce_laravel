@extends('admin.layouts.layout')

@section('admim_layout')
@section('admin_title_page')
Dashboard product-manageRew
@endsection
<div class="row">
<div class="col-12">

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Productos añadidos por ti</h5>
        </div>
        <div class="card-body">
        @if ($errors->any())
    <div class="alert alert-warning alert-disimissible fade show">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
<div class="alert alert-success">
    {{session('success')}}
</div>
@endif

   <div class="table reponsive">
    <table class="table">
        <thead>
            <th>#</th>
            <th>nombre del producto</th>
            <th>cantidad disponible</th>
            <th>precio</th>
            <th>opciones</th>
        </thead>
        <tbody>
            @foreach($productos as $producto)
            <tr>
                <td>{{$producto->id}}</td>
                <td>{{$producto->name}}</td>
                <td>{{$producto->stock}}</td>
                <td>${{$producto->price}}</td>
                <td>
                <form action="{{route('product.pageEdit')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$producto->id}}">
                    <button type="submit" class="btn btn-primary mb-2" >Editar</button>
                </form>
                    <form action="{{route('product.delete')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$producto->id}}">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
               
            </td>
            </tr> 
            @endforeach
        </tbody>
    </table>
   </div>
            
        </div>
    </div>
</div> 
</div>
@endsection