<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    public function disfrazs()
    {
        return $this->belongsToMany(Disfraz::class)
            ->withTimestamps();
    }

    protected $fillable = ['nombre', 'descripcion'];
}
