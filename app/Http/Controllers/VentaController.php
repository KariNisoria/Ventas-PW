<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVentaRequest;
use App\Models\Comprobante;
use App\Models\Producto;
use App\Models\Venta;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $ventas = Venta::with(['comprobante','user'])
        ->where('estado',1)
        ->latest()
        ->get();
        return view('venta.index',compact('ventas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productos = Producto::where('estado', 1)->get();
        $comprobantes = Comprobante::all();
      
        return view('venta.create',compact('productos','comprobantes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVentaRequest $request)
    {
       
       try{
        DB::beginTransaction();
     
        $venta = Venta::create($request->validated());

        //recuperar arrays
        $arrayProducto_id = $request->get('arrayidproducto');
        $arraycantidad = $request->get('arraycantidad');
        $arrayprecioVenta = $request->get('arrayprecioVenta');
        $arraydescuento = $request->get('arraydescuento');

        //llenar tabla
        $sizeArray = count($arrayProducto_id);
        $cont = 0;
        while($cont<$sizeArray){
            $venta->productos()->syncWithoutDetaching([
                $arrayProducto_id[$cont] => [
                    'cantidad'=> $arraycantidad[$cont],
                    'precio_venta'=> $arrayprecioVenta[$cont],
                    'descuento'=>  $arraydescuento[$cont]
                ]
               

            ]);
            //actualizo stock
            $producto = Producto::find($arrayProducto_id[$cont]);
            $stockActual = $producto->stock;
            $stockUsado = intval($arraycantidad[$cont]);
            DB::table('productos')
            ->where('id',$producto->id)
            ->update([
                'stock' => $stockActual - $stockUsado
            ]);
           
            $cont++;
        }
        DB::commit();
       }catch(Exception $e){
        dd($e);
        DB::rollBack();

       }
       return redirect()->route('ventas.index')->with('success','Venta registrada');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Venta $venta)
    {
       return view('venta.show',compact('venta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Venta::where('id', $id)
        ->update([
            'estado' => 0
        ]);
     return redirect()->route('ventas.index')->with('success','Venta eliminada');
    }
}
