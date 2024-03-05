@extends('template')

@section('title','Categorías')

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
    <h1 class="mt-4">Categorías</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item "><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Categorias</li>
    </ol>
    <div class = "mb-4" >
        <a href="{{route('categorias.create')}}">
            <button type="button" class="btn btn-primary">Añadir categoría</button>
        </a>
    </div>
    
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Lista de categorías
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                        
                    </tr>
                </thead>                
                <tbody>
                   @foreach ($categorias as $categoria)
                       <tr>
                            <td>{{$categoria->nombre}}</td>
                            <td>{{$categoria->descripcion}}</td>
                            <td>
                                @if ($categoria->estado == 1)
                                <span class="fw_bolder p-1 rounded bg-success text-white">Activo</span>
                                @else
                                <span class="fw_bolder p-1 rounded bg-danger text-white">No activo</span>
                                @endif
                                </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">

                                    <form action="{{route('categorias.edit',['categoria'=>$categoria])}}" method="get">
                                        
                                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i>Editar</i></button>
                                    </form>

                                    @if ($categoria->estado == 1)
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$categoria->id}}"><i class="fa-solid fa-trash">Eliminar</i></button>
                                    @else   
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$categoria->id}}"><i class="fa-solid fa-trash-arrow-up">Restaurar</i></button> 
                                    @endif
                                    
                               </div></td>
                       </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="confirmModal-{{$categoria->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Cambios categoría</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {{$categoria->estado == 1 ? '¿Estás seguro de eliminar la categoría?' :'¿Estás seguro de restaurar la categoría?'}}
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <form action="{{route('categorias.destroy',['categoria'=>$categoria->id])}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Confirmar</button>
                                </form>
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
{{-- <script src="{{asset ('js/datatables-simple-demo.js')}}"></script> --}}
@endpush