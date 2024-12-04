<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipos')->insert([
            ['nombre' => 'Prenda de vestir', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Fantasia', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Accesorio', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Armas y herramientas', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
