<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Cambiamos la clase de la que heredamos para que sea la clase User de Laravel.
class Usuario extends User
{
//    use HasFactory;
    // Agregamos los "traits" que Laravel requiere para la autenticación.
    use HasApiTokens, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'usuario_id';

    protected $fillable = ['email', 'password'];

    // Definimos los campos que queremos que Laravel ignore en la "serialización" del modelo.
    // "Serializar" es la técnica de convertir un objeto a una versión en formato string que
    // sea reversible. Es decir, debe poder recuperarse el valor original.
    protected $hidden = ['password', 'remember_token'];
}
