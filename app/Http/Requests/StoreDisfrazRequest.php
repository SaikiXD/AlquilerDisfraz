<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDisfrazRequest extends FormRequest
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
            'nombre' => 'required|unique:disfrazs,nombre|max:255',
            'nroPiezas' => 'required|integer',
            'cantidad' => 'required|integer',
            'descripcion' => 'nullable|string',
            'img_path' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'precio' => 'required|numeric|min:0|max:100000',
            'genero' => 'required|string|max:255',
            'categorias' => 'required'
        ];
    }
    public function attributes()
    {
        return [
            'nroPiezas' => 'piezas',
        ];
    }
}
