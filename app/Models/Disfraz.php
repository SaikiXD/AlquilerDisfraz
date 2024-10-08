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
        'nroPiezas',
        'cantidad',
        'descripcion',
        'img_path',
        'color',
        'edad_min',
        'edad_max',
        'precio',
        'genero'
    ];

    public function alquilers()
    {
        return $this->belongsToMany(Alquiler::class)
            ->withTimestamps()
            ->withPivot('cantidad', 'precio_venta');
    }

    public function categorias()
    {
        return $this->belongsToMany(Categoria::class)
            ->withTimestamps();
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
