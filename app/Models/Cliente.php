<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    public function disfrazs()
    {
        return $this->belongsToMany(Disfraz::class)->withTimestamps()
            ->withPivot(
                'img_path',
                'descripcion_garantia',
                'valor_garantia',
                'cantidad',
                'fecha_alquiler',
                'fecha_devolucion'
            );
    }
}
