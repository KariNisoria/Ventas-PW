@extends('template')

@section('title','Ventas')

@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
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
    <h1 class="mt-4">Ventas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item "><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Ver ventas</li>
    </ol>

    <div class = "mb-4" >
        <a href="{{route('ventas.create')}}">
            <button type="button" class="btn btn-primary">Iniciar venta</button>
        </a>
    </div>
    
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Lista de ventas
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Comprobante</th>
                        <th>Usuario</th>
                        <th>Total</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                        
                    </tr>
                </thead>                
                <tbody>
                   @foreach ($ventas as $venta)
                       <tr>
                            <!--comprobante--->
                            <td><p class="fw-semibold mb-1">{{$venta->comprobante->tipo_comprobante}}</p>
                                <p class="text-muted mb-0">{{$venta->numero_comprobante}}</p>
                            </td>
                             <!--usuario--->
                            <td>
                                {{$venta->user->name}}
                            </td>
                            <!--total--->
                            <td>    
                                {{$venta->total}}                  
                            </td>
                            <!--Fecha--->
                            <td>    
                                {{
                                    \Carbon\Carbon::parse($venta->fecha_hora)->format('d-m-Y').''.
                                    \Carbon\Carbon::parse($venta->fecha_hora)->format('H:i')
                                }}                    
                            </td>
                          <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    <form action="{{route('ventas.show',['venta'=>$venta])}}" method="get">
                                        <button type="submit" class="btn btn-black"><i class="fa-solid fa-camera-retro">Ver</i></button>
                                    </form>

                                    @if ($venta->estado == 1)
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$venta->id}}"><i class="fa-solid fa-trash">Eliminar</i></button>
                                    @else   
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$venta->id}}"><i class="fa-solid fa-trash-arrow-up">Restaurar</i></button> 
                                    @endif
                                    
                            </div>
                        </td>
                       </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="confirmModal-{{$venta->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Eliminar categoría</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {{$venta->estado == 1 ? '¿Estás seguro de eliminar la categoría?' :'¿Estás seguro de restaurar la categoría?'}}
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <form action="{{route('ventas.destroy',['venta'=>$venta->id])}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Confirmar</button>
                                </form>
                                </div>
                            </div>
                            </div>
                        </div>
                         <!-- Modal VER -->
                         <div class="modal fade" id="verModal-{{$venta->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{$venta->id}}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                           <label for=""><span class="fw-bolder">Stock: </span>{{$venta->cantidad}}</label> 
                                        </div>
                                        <div class="row mb-3">
                                            <label><span class="fw-bolder">Vista previa</span></label>
                                            <div>
                                                    <label for="">No hay vista previa</label>
                                               
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary"
                                            data-bs-dismiss="modal">Cerrar</button>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                   @endforeach
                   
                </tbody>
               
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://unpkg.com/simple-datatables" type="text/javascript"></script>
@endpush