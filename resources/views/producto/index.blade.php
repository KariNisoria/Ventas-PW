@extends('template')

@section('title', 'Productos')

@push('css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@section('content')
    @if (session('success'))
        <script>
            let message = "{{ session('success') }}";
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
        <h1 class="mt-4">Productos</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item "><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Productos</li>
        </ol>
        <div class = "mb-4">
            <a href="{{ route('productos.create') }}">
                <button type="button" class="btn btn-primary">Añadir Producto</button>
            </a>
        </div>


        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Lista de productos
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                            <th>Acciones</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $producto)
                            <tr>
                                <td>{{ $producto->codigo }}</td>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->descripcion }}</td>
                                <td>{{ $producto->categoria->nombre }}</td>
                                <td>
                                    @if ($producto->estado == 1)
                                        <span class="fw_bolder rounded p-1 bg-success text-white">Activo</span>
                                    @else
                                        <span class="fw_bolder rounded p-1 bg-danger text-white">No activo</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">

                                        <form action="{{route('productos.edit',['producto'=>$producto])}}" method="get">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fa-solid fa-pen-to-square"></i>Editar</i></button>
                                        </form>

                                        <button type="button" class="btn btn-black" data-bs-toggle="modal"
                                            data-bs-target="#verModal-{{$producto->id}}"><i class="fa-solid fa-camera-retro">Ver</i></button>

                                        @if ($producto->estado == 1)
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-{{ $producto->id }}"><i
                                                    class="fa-solid fa-trash">Eliminar</i></button>
                                        @else
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-{{ $producto->id }}"><i
                                                    class="fa-solid fa-trash-arrow-up">Restaurar</i></button>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                            <!-- Modal VER -->
                            <div class="modal fade" id="verModal-{{$producto->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">{{$producto->nombre}}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                               <label for=""><span class="fw-bolder">Stock: </span>{{$producto->stock}}</label> 
                                            </div>
                                            <div class="row mb-3">
                                                <label><span class="fw-bolder">Vista previa</span></label>
                                                <div>
                                                    @if ($producto->img_path != null)
                                                        <img src="{{Storage::url('public/productos/'.$producto->img_path)}}" alt="{{$producto->nombre}}" class="img-fluid img-thumbnail border border-4 rounded">   
                                                    @else
                                                        <label for="">No hay vista previa</label>
                                                    @endif
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
                            <!-- Modal ELIMINAR-->
                        <div class="modal fade" id="confirmModal-{{$producto->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Cambios producto</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {{$producto->estado == 1 ? '¿Estás seguro de eliminar el producto?' :'¿Estás seguro de restaurar el producto?'}}
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <form action="{{route('productos.destroy',['producto'=>$producto->id])}}" method="POST">
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
@endpush
