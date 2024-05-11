<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alquiler extends Model
{
    use HasFactory;

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function disfrazs()
    {
        return $this->belongsToMany(Disfraz::class)
            ->withTimestamps()
            ->withPivot('cantidad', 'precio_venta');
    }
}
