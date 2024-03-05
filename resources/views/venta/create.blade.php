@extends('template')

@section('title', 'Crear venta')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')


<div class="container-fluid px-4">
    <h1 class="mt-4">Realizar Venta</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item "><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item active"><a href="{{route('ventas.index')}}">Ventas</a></li>
        <li class="breadcrumb-item active">Realizar venta</li>
    </ol>
</div>

<form action="{{route('ventas.store')}}" method="post">
    @csrf
    <div class="container mt-4">
        <div class="row gy-4">
            <!---venta producto--->
            <div class="col-md-8">
                <div class="text-white bg-primary p-1 text-center">
                    Detalles de la venta
                </div>
                <div class="p-3 border border-3 border-primary">
                    <div class="row">
                        <!--producto-->
                        <div class="col-md-12 mb-4">
                            <select name="producto_id" id="producto_id" title="Seleccione una opción" class="form-control selectpicker" data-live-search="true" data-size="4">
                                @foreach ($productos as $producto)
                                    <option value="{{$producto->id}}-{{$producto->stock}}-{{$producto->precio_venta}}">{{$producto->codigo.' '.$producto->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--stock-->
                        <div class="d-flex justify-content-end">
                            <div class="col-md-6 mb-2">
                                <div class="row">
                                    <label for="stock" class="form-label col-sm-4">Stock disponible:</label>
                                    <div class="col-sm-8">
                                        <input disabled type="number" name="stock" id="stock" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!--cantidad-->
                        <div class="col-md-4 mb-2">
                            <label for="cantidad" class="form-label">Cantidad:</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control">
                        </div>
                        <!--Precio de venta-->
                        <div class="col-md-4 mb-2">
                            <label for="precio_venta" class="form-label">Precio de venta:</label>
                            <input disabled type="number" name="precio_venta" id="precio_venta" class="form-control" step="0.1">
                        </div>
                        <!--Descuento-->
                        <div class="col-md-4 mb-2">
                            <label for="descuento" class="form-label">Descuento:</label>
                            <input type="number" name="descuento" id="descuento" class="form-control">
                        </div>
                        <div class="col-md-12 mb-4 mt-2 text-end">
                            <button id="btn_agregar" class="btn btn-primary" type="button">Agregar</button>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="tabla_detalle" class="table table-hover">
                                    <thead class="bn-primary text-black">
                                        <tr>
                                            <th>#</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio venta</th>
                                            <th>Descuento</th>
                                            <th>Subtotal</th>
                                            <th></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th></th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th colspan="4">Total</th>
                                            <th colspan="2"><input type="hidden" name = "total" value="0" id="inputTotal"> <span id="sumas">0</span></th>
                                        </tr>
                                     
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                         <!--Cancelar-->
                         <div class="col-md-12 mb-2">
                            <button id="cancelar" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Cancelar venta
                            </button>
                         </div>
                    </div>

                </div>
            </div>
            <!---Venta--->
            <div class="col-md-4">
                <div class="text-white bg-success p-1 text-center">
                    Datos generales
                </div>
                <div class="p-3 border border-3 border-success">
                    <div class="row">
                        <!--Tipo comprobante-->
                        <div class="col-md-12 mb-2">
                            <label for="comprobante_id" class="form-label">Comprobante:</label>
                            <select name="comprobante_id" id="comprobante_id" class="form-control selectpicker" data-live-search="true" data-size="4">
                                @foreach ($comprobantes as $comprobante)
                                    <option value="{{$comprobante->id}}">{{$comprobante->tipo_comprobante}}</option>
                                @endforeach
                            </select>
                            @error('comprobante_id')
                             <small class="text-danger">{{'*'.$message}}</small>   
                            @enderror
                        </div>

                         <!--Fecha-->
                         <div class="col-md-6 mb-4">
                            <label for="numero_comprobante" class="form-label">Numero comprobante:</label>
                            <input type="number" name="numero_comprobante" id="numero_comprobante" class="form-control" value="{{old('numero_comprobante')}}">
                        </div>

                         <div class="col-md-6 mb-4">
                            <label for="fecha" class="form-label">Fecha:</label>
                            <input readonly type="date" name="fecha" id="fecha" class="form-control border-success" value="<?php echo date("Y-m-d") ?>">
                            <?php
                              use Carbon\Carbon;
                              $fecha_hora = Carbon::now()->toDateTimeString();  
                            ?>
                            <input type="hidden" name="fecha_hora" value="{{$fecha_hora}}">
                        </div>
                        
                        <input type="hidden" name="user_id" value="{{auth()->user()->id}}">

                         <!--Boton guardar-->
                         <div class="col-md-12 mb-2 text-center">
                            <button type="submit" class="btn btn-success" id="guardar">Guardar</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
     <!---Modal para cancelar--->
     <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title fs-5" id="exampleModalLabel">Eliminar producto</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               ¿Estás seguro de cancelar la venta?
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button id="btnCancelarVenta" type="button" class="btn btn-danger" data-bs-dismiss="modal">Confirmar</button>
           
            </div>
        </div>
        </div>
    </div>
  
</form> 
@endsection


@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <script>
        $('document').ready(function(){
            $('#producto_id').change(mostrarValores);

            $('#btn_agregar').click(function(){
                agregarProducto();
            });
            
            $('#btnCancelarVenta').click(function(){
                cancelarVenta();
            });
            
            disableButtons();
        });

        let cont = 0;
        let subtotal = [];
        let sumas = 0;
        let montoDescuento = 0;
        let total = 0;
        let descuento = 0;
        let cantidad = 0;

        function mostrarValores(){
            let dataProducto = document.getElementById('producto_id').value.split('-');
            $('#stock').val(dataProducto[1]);
            $('#precio_venta').val(dataProducto[2]);
            
        }
        function agregarProducto(){
            let dataProducto = document.getElementById('producto_id').value.split('-');
            let idProducto = dataProducto[0];
            let nameProducto = $('#producto_id option:selected').text();
            let stock = $('#stock').val();
            let cantidad = $('#cantidad').val();
            let precioVenta = $('#precio_venta').val();  
            let descuento = $('#descuento').val();
            if(descuento == ''){
                descuento = 0;
            }
            if(idProducto != '' && cantidad != ''){
                if(parseInt(cantidad)>=0 && (cantidad % 1 == 0) && parseFloat(descuento)>=0){
                    if(parseInt(cantidad)<= parseInt(stock)){

                        subtotal[cont] = round(cantidad * precioVenta - descuento);
                        sumas+= subtotal[cont];
                        //montoDescuento+ = descuento[cont];
                        total = round(sumas);

                        let fila = '<tr id= "fila' + cont + '">' +
                        '<th>'+ (cont + 1) + '</th>' +
                        '<td><input type="hidden" name="arrayidproducto[]" value="'+ idProducto +'">' + nameProducto +'</td>' +
                        '<td><input type= "hidden" name="arraycantidad[]" value="'+ cantidad +'">'+ cantidad +'</td>' +
                        '<td><input type= "hidden" name="arrayprecioVenta[]" value="'+ precioVenta +'">'+ precioVenta +'</td>' +
                        '<td><input type= "hidden" name="arraydescuento[]" value="'+ descuento +'">'+ descuento +'</td>' +
                        '<td>'+ subtotal[cont] + '</td>' +
                        '<td><button class="btn btn-danger" type="button" onClick="eliminarProducto(' + cont + ')"><i class="fa-solid fa-trash"><i/></td>'+
                        '</tr>'; 

                        $('#tabla_detalle').append(fila);
                        console.log(fila);
                        limpiarCampos();
                        cont++;
                        disableButtons();

                        $('#sumas').html(sumas);
                        $('#total').html(total);
                        $('#descuento').html(montoDescuento);
                        $('#inputTotal').val(total);

                    }else{
                        showModal('Cantidad incorrecta');
                    }

                }else{
                        showModal('Valores incorrectos');
                    }
            }else{
                        showModal('Faltan llenar campos');
                    }
            
        }
        
        function round(num, decimales = 2){
            var signo = (num>= 0 ? 1 : -1);
            num = num * signo;
            if(decimales === 0){
                return signo * Math.round(num);
            }
            else{
                num = num.toString().split('e');
                num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));

                num = num.toString().split('e');
                return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : - decimales));
            }
        }
        function limpiarCampos(){
            let select = $('#producto_id');
            select.selectpicker('val','');
            $('#stock').val('');
            $('#cantidad').val('');
            $('#precio_venta').val('');
            $('#descuento').val('');
            
        }
        function disableButtons(){
            if(total== 0){
                $('#guardar').hide();
                $('#cancelar').hide();
            }else{
                $('#guardar').show();
                $('#cancelar').show();
            }
        }
        function showModal(message, icon = 'error'){
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar:true,
                didOpen:(toast) =>{
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseenter', Swal.resumeTimer)
                }
            })
            Toast.fire({
                icon:icon,
                title: message
            })
        }
        function eliminarProducto(indice){
            sumas -= round(subtotal[indice],2);
            total = sumas;

            $('#sumas').html(sumas);
            $('#total').html(total);
            $('#InputTotal').val(total);

            $('#fila' + indice).remove();
            disableButtons();
        }

        function cancelarVenta(){
            //limpiar tabla
            $('#tabla_detalle tbody').empty();
            //Nueva fila a la tabla
            let fila = '<tr>' +
            '<th></th>'+
            '<td></td>'+
            '<td></td>'+
            '<td></td>'+
            '<td></td>'+
            '<td></td>'+
            '</tr>';
            $('#tabla_detalle').append(fila);

            //reinicio variables
            cont = 0;
            subtotal =[];
            sumas = 0;
            total = 0;

            //mostrar calculados
            $('#sumas').html(sumas);
            $('#total').html(total);
            $('#inputTotal').val(total);

            limpiarCampos();
            disableButtons();


        }
    </script>
@endpush