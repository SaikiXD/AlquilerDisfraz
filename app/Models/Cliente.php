<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    public function alquiler()
    {
        return $this->hasMany(Alquiler::class);
    }
    protected $fillable = ['nombre', 'ci', 'gmail', 'direccion', 'celular'];
}
