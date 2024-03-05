<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use Exception;
use Spatie\LaravelIgnition\Http\Requests\UpdateConfigRequest;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::with(['categoria'])->latest()->get();
        return view('producto.index',compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::where('estado','=','1')->get();
        return view('producto.create',compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductoRequest $request)
    {
        try{
            DB::beginTransaction();
            $producto = new Producto();
            if ($request->hasFile('img_path')) {
              $name = $producto->hanbleUploadImagen($request->file('img_path'));
            } else {
              $name = null;
            }
            $producto->fill([
                'codigo'=> $request->codigo,
                'nombre'=> $request->nombre,
                'stock'=> $request->stock,
                'descripcion' => $request->descripcion,
                'precio_venta'=> $request->precio_venta,
                'img_path' => $name,
                'categoria_id' => $request->categoria_id
            ]);
            $producto->save();
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        };
        return redirect()->route('productos.index')->with('success','Los datos se guardaron correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        $categorias = Categoria::where('estado','=','1')->get();
        return view('producto.edit', compact('producto','categorias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        try{
            DB::beginTransaction();
          
            if ($request->hasFile('img_path')) {
                $name = $producto->hanbleUploadImagen($request->file('img_path'));
                if(Storage::disk('public')->exists('productos/'.$producto->img_path)){
                    
                    Storage::disk('public')->delete('productos/'.$producto->img_path);
                }

            }else {
              $name = $producto->img_path;
            }
            $producto->fill([
                'codigo'=> $request->codigo,
                'nombre'=> $request->nombre,
                'stock'=> $request->stock,
                'descripcion' => $request->descripcion,
                'precio_venta' => $request->precio_venta,
                'img_path' => $name,
                'categoria_id' => $request->categoria_id
            ]);
            $producto->save();
            DB::commit();

        }catch(Exception $e){
            DB::rollBack();
        };
        return redirect()->route('productos.index')->with('success','Producto modificado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $message = '';
        $producto = Producto::find($id);
        if ($producto->estado == 1) {
            Producto::where('id', $producto->id)
                ->update([
                    'estado' => 0
                ]);
            $message = 'Producto eliminado';
        } else {
            Producto::where('id', $producto->id)
                ->update([
                    'estado' => 1
                ]);
            $message = 'Producto restaurado';
        }

        return redirect()->route('productos.index')->with('success', $message);
    }
}
