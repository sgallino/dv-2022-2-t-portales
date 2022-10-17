<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Pedimos que ejecute este Seeder.
        $this->call(CategoriaSeeder::class);
        $this->call(PaisesSeeder::class);
        $this->call(GenerosSeeder::class);
        $this->call(PeliculasSeeder::class);
        $this->call(PeliculasTienenGenerosSeeder::class);
        $this->call(UsuarioSeeder::class);
    }
}
