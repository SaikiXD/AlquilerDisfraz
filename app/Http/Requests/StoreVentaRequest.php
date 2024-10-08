<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVentaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'descripcion_garantia' => 'nullable|string',
            'valor_garantia' => 'nullable|numeric',
            'fecha_alquiler' => 'required|date',
            'fecha_devolucion' => 'required|date',
            'total' => 'required|numeric',
            'cliente_id' => 'required|exists:clientes,id',
            //'user_id' => 'required|exists:users,id'
            'garantia_id' => 'required|exists:garantias,id'
        ];
    }
}
