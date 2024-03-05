<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'codigo' => 'required|unique:productos,codigo|max:45',
            'nombre' => 'required|unique:productos,nombre|max:45',
            'stock' => 'nullable|integer',
            'descripcion' => 'nullable|max:255',
            'precio_venta' => 'decimal:1',
            'img_path' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'categoria_id' => 'required|integer|exists:categorias,id'
        ];
    }

    public function attributes(){
        return[
            'categoria_id' => 'categoria'
        ];
    }
}
