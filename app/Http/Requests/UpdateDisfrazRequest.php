<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDisfrazRequest extends FormRequest
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
        $disfraz = $this->route('disfraz');
        return [
            /*'nombre' => 'required|unique:disfrazs,nombre,' . $disfraz->id . '|max:80',
            'descripcion' => 'nullable|max:255',
            'img_path' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'genero' => 'required|string|max:255',
            'categorias' => 'required'*/
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'genero' => 'required|in:masculino,femenino,unisex',
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'precio' => 'required|numeric|min:0',

            'categorias' => 'required|array',
            'categorias.*' => 'exists:categorias,id'
        ];
    }
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del disfraz es obligatorio.',
            'genero.required' => 'El género es obligatorio.',
            'img_path.image' => 'El archivo debe ser una imagen válida.',
            'img_path.mimes' => 'La imagen debe estar en formato: jpeg, png, jpg o gif.',
            'precio.required' => 'El precio es obligatorio.',
            'categorias.required' => 'Debe seleccionar al menos una categoría.',
            'categorias.*.exists' => 'La categoría seleccionada no es válida.',
        ];
    }
}
