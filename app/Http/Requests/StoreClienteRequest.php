<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
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
            'nombre' => 'required|string|max:255',
            'ci' => 'required|integer|unique:clientes,ci',
            'gmail' => 'nullable|email|unique:clientes,gmail|max:255',
            'direccion' => 'required|string|max:255',
            'celular' => 'required|integer|unique:clientes,celular|min:1000000|max:99999999',
        ];
    }
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del cliente es obligatorio.',
            'ci.required' => 'El número de CI es obligatorio.',
            'ci.unique' => 'El número de CI ya está registrado.',
            'gmail.email' => 'Debe proporcionar un correo electrónico válido.',
            'gmail.unique' => 'El correo electrónico ya está registrado.',
            'direccion.required' => 'La dirección es obligatoria.',
            'celular.required' => 'El número de celular es obligatorio.',
            'celular.unique' => 'El número de celular ya está registrado.',
            'celular.min' => 'El número de celular debe tener al menos 7 dígitos.',
            'celular.max' => 'El número de celular no puede exceder 8 dígitos.',
        ];
    }
}
