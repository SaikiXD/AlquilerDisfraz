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
            'nombre' => 'required|unique:disfrazs,nombre,' . $disfraz->id . '|max:255',
            'nroPiezas' => 'required|integer',
            'cantidad' => 'required|integer',
            'descripcion' => 'nullable|string',
            'img_path' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'color' => 'required|string|max:255',
            'edad_min' => 'required|integer|min:3',
            'edad_max' => 'required|integer|min:3',
            'precio' => 'required|numeric|min:0|max:100000',
            'genero' => 'required|string|max:255',
            'categorias' => 'required'
        ];
    }
    public function attributes()
    {
        return [
            'nroPiezas' => 'piezas',
            'edad_min' => 'edad minima',
            'edad_max' => 'edad maxima'
        ];
    }
    public function withValidator($validacion)
    {
        $validacion->after(function ($validacion) {
            if ($this->edad_min >= $this->edad_max) {
                $validacion->errors()->add('edad_min', 'La edad mínima debe ser menor que la edad máxima.');
                $validacion->errors()->add('edad_max', 'La edad máxima debe ser mayor que la edad mínima.');
            }
        });
    }
}
