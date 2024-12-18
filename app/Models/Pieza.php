<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pieza extends Model
{
    use HasFactory;

    public function disfrazs()
    {
        return $this->belongsToMany(Disfraz::class)
            ->withTimestamps()
            ->withPivot('cantidad', 'color', 'talla', 'material');
    }
    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'tipo_id');
    }
    protected $fillable = [
        'nombre',
        'tipo_id'
    ];
}
