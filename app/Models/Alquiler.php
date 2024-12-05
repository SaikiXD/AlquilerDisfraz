<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Alquiler extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'img_path_garantia',
        'descripcion_garantia',
        'tipo_garantia',
        'valor_garantia',
        'fecha_alquiler',
        'fecha_devolucion'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function disfrazs()
    {
        return $this->belongsToMany(Disfraz::class)
            ->withTimestamps()
            ->withPivot('cantidad', 'precio_unitario');
    }
    public function hanbleUploadImage($image)
    {
        $file = $image;
        $name = time() . $file->getClientOriginalName();
        //$file->move(public_path() . '/img/productos/' . $name);
        Storage::putFileAs('/public/alquilers/', $file, $name, 'public');
        return $name;
    }
}
