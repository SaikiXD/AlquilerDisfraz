<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StoreAlquilerRequest extends FormRequest
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
        Log::info('Datos recibidos para validación:', $this->all());
        return [
            'cliente_id' => 'required|exists:clientes,id',
            'tipo_garantia' => 'required|string|in:dinero,documento,objeto',
            'descripcion_garantia' => 'nullable|string|max:255',
            'valor_garantia' => 'nullable|numeric|min:0',
            'img_path_garantia' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'fecha_alquiler' => 'required',
            'fecha_devolucion' => 'required'
        ];
    }
    public function attributes()
    {
        return [
            'cliente_id' => 'cliente'
        ];
    }
    public function messages(): array
    {
        return [
            'cliente_id.required' => 'El cliente es obligatorio.',
            'cliente_id.exists' => 'El cliente seleccionado no existe.',
            'tipo_garantia.required' => 'El tipo de garantía es obligatorio.',
            'tipo_garantia.in' => 'El tipo de garantía no es válido.',
            'descripcion_garantia.max' => 'La descripción de la garantía no puede exceder los 255 caracteres.',
            'valor_garantia.numeric' => 'El valor de la garantía debe ser un número.',
            'valor_garantia.min' => 'El valor de la garantía no puede ser negativo.',
            'img_path_garantia.image' => 'El archivo debe ser una imagen válida.',
            'img_path_garantia.max' => 'La imagen no puede superar los 2 MB.',
        ];
    }
}
