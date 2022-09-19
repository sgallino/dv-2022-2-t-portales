<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenerosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('generos')->insert([
            [
                'genero_id' => 1,
                'nombre' => 'Acción',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'genero_id' => 2,
                'nombre' => 'Aventuras',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'genero_id' => 3,
                'nombre' => 'Bélicas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'genero_id' => 4,
                'nombre' => 'Comedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'genero_id' => 5,
                'nombre' => 'Ciencia Ficción',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'genero_id' => 6,
                'nombre' => 'Romance',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'genero_id' => 7,
                'nombre' => 'Históricas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'genero_id' => 8,
                'nombre' => 'Fantasía',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'genero_id' => 9,
                'nombre' => 'Drama',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
