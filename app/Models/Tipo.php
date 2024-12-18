<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'descripcion'];
    public function piezas()
    {
        return $this->hasMany(Pieza::class, 'tipo_id');
    }
}
