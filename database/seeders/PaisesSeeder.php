<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaisesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('paises')->insert([
            [
                'pais_id' => 1,
                'nombre' => 'Estados Unidos',
                'abreviatura' => 'USA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pais_id' => 2,
                'nombre' => 'Inglaterra',
                'abreviatura' => 'ENG',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pais_id' => 3,
                'nombre' => 'Argentina',
                'abreviatura' => 'ARG',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
