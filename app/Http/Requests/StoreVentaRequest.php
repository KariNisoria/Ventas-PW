<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVentaRequest extends FormRequest
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
            'fecha_hora' => 'required',
            'total' => 'required|numeric',
            'comprobante_id' =>'required|exists:comprobantes,id',
            'numero_comprobante' => 'required|unique:ventas,numero_comprobante|numeric',
            'user_id'=> 'required|exists:users,id'


        ];
    }
}
