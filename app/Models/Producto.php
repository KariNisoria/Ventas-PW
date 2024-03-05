<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Producto extends Model
{
    use HasFactory;

    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }

    public function ventas(){
        return $this->belongsToMany(Venta::class)->withTimestamps()->withPivot('cantidad','precio_venta','descuento');
    }

    protected $fillable =['codigo', 'nombre','stock','descripcion','precio_venta','img_path','categoria_id'];

    public function hanbleUploadImagen($image){
        $file = $image;
        $name = time().$file->getClientOriginalName();
       //$file->move(public_path().'/img/productos/', $name);
        Storage::putFileAs('/public/productos/',$file,$name,'public');
        return $name;
    }
}
