<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PiezaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener los IDs de la tabla `tipos` según sus nombres
        $tipos = DB::table('tipos')->pluck('id', 'nombre');

        // Datos de las piezas organizadas por tipos
        $piezas = [
            // Prendas de vestir
            ['tipo_id' => $tipos['Prenda de vestir'], 'nombre' => 'Polera', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Prenda de vestir'], 'nombre' => 'Pantalón', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Prenda de vestir'], 'nombre' => 'Falda', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Prenda de vestir'], 'nombre' => 'Camisa', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Prenda de vestir'], 'nombre' => 'Blusa', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Prenda de vestir'], 'nombre' => 'Chaqueta', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Prenda de vestir'], 'nombre' => 'Sombrero', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Prenda de vestir'], 'nombre' => 'Zapatos', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Prenda de vestir'], 'nombre' => 'Botas', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Prenda de vestir'], 'nombre' => 'Sandalias', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Prenda de vestir'], 'nombre' => 'Vestido', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Prenda de vestir'], 'nombre' => 'Túnica', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Accesorios
            ['tipo_id' => $tipos['Accesorio'], 'nombre' => 'Cinturón', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Accesorio'], 'nombre' => 'Gafas', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Accesorio'], 'nombre' => 'Joyas', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Accesorio'], 'nombre' => 'Máscara', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Accesorio'], 'nombre' => 'Peluca', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Accesorio'], 'nombre' => 'Barba', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Accesorio'], 'nombre' => 'Bigote', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Accesorio'], 'nombre' => 'Guantes', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Elementos de fantasía
            ['tipo_id' => $tipos['Fantasia'], 'nombre' => 'Alas', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Fantasia'], 'nombre' => 'Cola', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Fantasia'], 'nombre' => 'Cuernos', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Fantasia'], 'nombre' => 'Orejas', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Fantasia'], 'nombre' => 'Rabo', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Fantasia'], 'nombre' => 'Escamas', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Fantasia'], 'nombre' => 'Capa', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Fantasia'], 'nombre' => 'Cetro', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Armas y herramientas
            ['tipo_id' => $tipos['Armas y herramientas'], 'nombre' => 'Espada', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Armas y herramientas'], 'nombre' => 'Arco y flecha', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Armas y herramientas'], 'nombre' => 'Pistola', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Armas y herramientas'], 'nombre' => 'Kunai', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Armas y herramientas'], 'nombre' => 'Shuriken', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Armas y herramientas'], 'nombre' => 'Escudo', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Armas y herramientas'], 'nombre' => 'Hacha', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_id' => $tipos['Armas y herramientas'], 'nombre' => 'Lanza', 'estado' => 1, 'created_at' => now(), 'updated_at' => now()],
        ];

        // Insertar datos
        DB::table('piezas')->insert($piezas);
    }
}
