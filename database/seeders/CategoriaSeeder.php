<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('categorias')->insert([
            [
                'categoria_id' => 1,
                'nombre' => 'Apta Para Todo Público',
                'abreviatura' => 'ATP',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoria_id' => 2,
                'nombre' => 'Solo Mayores de 13 Años',
                'abreviatura' => 'M13',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoria_id' => 3,
                'nombre' => 'Solo Mayores de 16 Años',
                'abreviatura' => 'M16',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoria_id' => 4,
                'nombre' => 'Solo Mayores de 18 Años',
                'abreviatura' => 'M18',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
