<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeliculasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Dentro de este método deberíamos poner las inserciones que queremos sumar a nuestra tabla.
        // Por ejemplo, para hacer un INSERT, nos podemos ayudar con la "fachada" "DB" de Laravel.
        // "DB" nos da acceso a la clase de "Query Builder" de Laravel.
        // Una vez completo el Seeder, podemos registrarlo en "DatabaseSeeder" para que se sejecute con
        // el comando de Artisan.
        DB::table('peliculas')->insert([
            [
                'pelicula_id' => 1,
                'pais_id' => 1,
                'titulo' => 'El Señor de los Anillos: La Comunidad del Anillo',
                'precio' => 1999,
                'fecha_estreno' => '2001-01-03',
                'descripcion' => 'Viaje para reventar un anillo.',
                'portada' => null,
                'portada_descripcion' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pelicula_id' => 2,
                'pais_id' => 2,
                'titulo' => 'El Discurso del Rey',
                'precio' => 2199,
                'fecha_estreno' => '2014-05-17',
                'descripcion' => '"I have a voice!".',
                'portada' => null,
                'portada_descripcion' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pelicula_id' => 3,
                'pais_id' => 1,
                'titulo' => 'La Matrix',
                'precio' => 1599,
                'fecha_estreno' => '1999-11-22',
                'descripcion' => '"I know kung fu."',
                'portada' => null,
                'portada_descripcion' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('peliculas_tienen_generos')->insert([
            [
                'pelicula_id' => 1,
                'genero_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pelicula_id' => 1,
                'genero_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pelicula_id' => 1,
                'genero_id' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pelicula_id' => 2,
                'genero_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pelicula_id' => 2,
                'genero_id' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pelicula_id' => 3,
                'genero_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pelicula_id' => 3,
                'genero_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
