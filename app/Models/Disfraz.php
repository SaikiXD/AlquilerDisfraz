<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disfraz extends Model
{
    use HasFactory;

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
}
