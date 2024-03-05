@extends('template')

@section('title','Ver venta')

@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush

@section('content')
@if (session('success'))
<script>
    let message = "{{session('success')}}";
    const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
        didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
        }   
    });
Toast.fire({
  icon: "success",
  title: message
});
</script> 
@endif

<div class="container-fluid px-4">
    <h1 class="mt-4">Ver venta</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item "><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item "><a href="{{ route('ventas.index') }}">Ventas</a></li>
        <li class="breadcrumb-item active">Ventas</li>
    </ol>

    <div class = "container w-100" >
        <div class="card p-2 mb-4">
            <!--tipo comprobante-->
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-file"></i></span>
                        <input disabled type="text" class="form-control" value="Tipo de comprobante:">
                    </div>

                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="{{$venta->comprobante->tipo_comprobante}}">
                </div>

            </div>
            <!--comprobante-->
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
                        <input disabled type="text" class="form-control" value="Número de comprobante:">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="{{$venta->numero_comprobante}}">
                </div>
            </div>

            <!--Fecha-->
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                        <input disabled type="text" class="form-control" value="Fecha:">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="{{\Carbon\Carbon::parse($venta->fecha_hora)->format('d/m/Y')}}">
                </div>
            </div>

             <!--Hora-->
             <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-clock"></i></span>
                        <input disabled type="text" class="form-control" value="Hora:">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="{{\Carbon\Carbon::parse($venta->fecha_hora)->format('H:i')}}">
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla de detalle de venta
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Descuento</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($venta->productos as $producto)
                        <tr>
                            <td>{{$producto->nombre}}</td>
                            <td>{{$producto->pivot->cantidad}}</td>
                            <td>{{$producto->pivot->precio_venta}}</td>
                            <td>{{$producto->pivot->descuento}}</td>
                            <td class="td-subtotal">{{($producto->pivot->cantidad)*($producto->pivot->precio_venta)-($producto->pivot->descuento)}}</td>
                        </tr>
                            
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4">Total:</th>
                            <th id="th-total">{{$venta->total}}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    
    
    
</div>
@endsection

@push('js')
<script src="https://unpkg.com/simple-datatables" type="text/javascript"></script>
@endpush