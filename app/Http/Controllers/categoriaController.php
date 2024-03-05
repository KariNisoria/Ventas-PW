<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Categoria;
use Exception;
use Illuminate\Support\Facades\DB; 
use PhpParser\Node\Stmt\TryCatch;


class categoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categoria::latest()->get();
        
        return view('categoria.index',['categorias'=> $categorias]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categoria.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoriaRequest $request)
    {
       //dd($request);
       try{
        DB::beginTransaction();
        $categoria = Categoria::create($request->validated());
        DB::commit();

       }catch(Exception $e){
        DB::rollBack();
       }
       return redirect()->route('categorias.index')->with('success','Categoría ingresada correctamente');
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
    public function edit(Categoria $categoria)
    {
       
        return view('categoria.edit',['categoria'=>$categoria]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
       Categoria::where('id',$categoria->id)
       ->update($request->validated());

       return redirect()->route('categorias.index')->with('success','categoria editada');
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
       $categoria = Categoria::find($id);
       if($categoria->estado == 1){
        Categoria::where('id',$categoria->id)
        ->update([
             'estado' => 0
        ]);
        $message = 'Categoría eliminada';
       }else{
        Categoria::where('id',$categoria->id)
        ->update([
            'estado' => 1
       ]);
       $message = 'Categoría restaurada';
       }
       
       return redirect()->route('categorias.index')->with('success',$message);
    }
}
