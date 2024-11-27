<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Disfraz extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'nroPiezas',
        'img_path',
        'genero',
        'precio'
    ];

    public function piezas()
    {
        return $this->belongsToMany(Pieza::class)
            ->withTimestamps()
            ->withPivot('cantidad', 'color', 'talla', 'material');
    }

    public function categorias()
    {
        return $this->belongsToMany(Categoria::class)
            ->withTimestamps();
    }
    public function clientes()
    {
        return $this->belongsToMany(Cliente::class)->withTimestamps()
            ->withPivot(
                'img_path',
                'descripcion_garantia',
                'valor_garantia',
                'cantidad',
                'fecha_alquiler',
                'fecha_devolucion'
            );
    }
    public function hanbleUploadImage($image)
    {
        $file = $image;
        $name = time() . $file->getClientOriginalName();
        //$file->move(public_path() . '/img/productos/' . $name);
        Storage::putFileAs('/public/disfrazs/', $file, $name, 'public');
        return $name;
    }
}
