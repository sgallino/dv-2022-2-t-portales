<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('usuarios')->insert([
            [
                'usuario_id' => 1,
                'email' => 'sara@za.com',
                // Hash::make() es la versión de Laravel del password_hash().
                'password' => \Hash::make('asdasd'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
