<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categorias')->insert([
            [
                'nombre' => 'Fantasía',
                'descripcion' => 'Categoría que incluye disfraces relacionados con elementos fantásticos como hadas, magos, y criaturas mitológicas.',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Históricos',
                'descripcion' => 'Disfraces basados en personajes y estilos de épocas pasadas, como guerreros romanos o piratas.',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Profesiones',
                'descripcion' => 'Incluye disfraces representativos de diferentes profesiones, como médicos, policías o bomberos.',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Superhéroes',
                'descripcion' => 'Disfraces inspirados en personajes de cómics, películas y series de superhéroes.',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Terror',
                'descripcion' => 'Categoría de disfraces relacionados con personajes y temáticas de terror, como zombis, vampiros y brujas.',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Animales',
                'descripcion' => 'Disfraces inspirados en animales de todo tipo, ideales para niños y adultos.',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Cultura Pop',
                'descripcion' => 'Disfraces de personajes y elementos icónicos de la cultura pop, como series, películas y videojuegos.',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Infantiles',
                'descripcion' => 'Disfraces diseñados especialmente para niños pequeños con temas divertidos y coloridos.',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
