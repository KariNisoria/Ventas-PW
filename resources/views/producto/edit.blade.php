@extends('template')

@section('title','Editar producto')

@push('css')
<style>
    #descripcion{
        resize:none;
    }
    .limitar{
        max-width:200px;
    }
    .limitar2{
        max-width:400px;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4">Editar producto</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item "><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item active"><a href="{{route('productos.index')}}">Productos</a></li>
        <li class="breadcrumb-item active">Editar producto</li>
    </ol>

    <div class="conteiner w-100 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{route('productos.update',['producto'=>$producto])}}" method="post" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="row g-3">

                <div class="col-12">
                    <label for="codigo" class="form-label">Código:</label>
                    <input type="text" name="codigo" id="codigo" class="form-control limitar2" value="{{old('codigo',$producto->codigo)}}">
                    @error('codigo')
                    <small class="text-danger">{{'* '.$message}}</small>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre',$producto->nombre)}}">
                    @error('nombre')
                    <small class="text-danger">{{'* '.$message}}</small>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="3" class="form-control">{{old('descripcion',$producto->descripcion)}}</textarea>
                    @error('descripcion')
                    <small class="text-danger">{{'* '.$message}}</small>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="precio_venta" class="form-label">Precio:</label>
                    <input type="text" name="precio_venta" id="precio_venta" class="form-control" value="{{old('precio_venta',$producto->precio_venta)}}">
                    @error('precio_venta')
                    <small class="text-danger">{{'* '.$message}}</small>
                    @enderror
                </div>

                <div class="col-12 ">
                    <label for="stock" class="form-label">Stock:</label>
                    <input type="text" name="stock" id="stock" class="form-control limitar" value="{{old('stock',$producto->stock)}}">
                    @error('stock')
                    <small class="text-danger">{{'* '.$message}}</small>
                    @enderror
                </div>
                <div class="col-6 ">
                    <label for="stock" class="form-label">Imagen:</label>
                    <input type="file" name="img_path" id="img_path" class="form-control" accept="Image/*" >
                    @error('img_path')
                    <small class="text-danger">{{'* '.$message}}</small>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="categoria_id" class="form-label">Categoria:</label>
                    <select data-size="4" title="Seleccione una opción" data-live-search="true" name="categoria_id" id="categoria_id" class="form-control selectpicker show-tick">
                        @foreach ($categorias as $categoria)
                            @if ($producto->categoria_id == $categoria->id)
                                <option selected value="{{$categoria->id}}" {{old('categoria_id') == $categoria->id ? 'selected' : '' }}>{{$categoria->nombre}}</option>
                            @else
                                <option value="{{$categoria->id}}" {{old('categoria_id') == $categoria->id ? 'selected' : '' }}>{{$categoria->nombre}}</option>
                            @endif
                            
                        @endforeach

                    </select>
                    @error('categoria_id')
                    <small class="text-danger">{{'* '.$message}}</small>
                    @enderror
                </div>

                <div class="col-12 text">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form> 

    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
@endpush