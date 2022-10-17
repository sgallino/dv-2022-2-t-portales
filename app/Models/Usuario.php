<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Cambiamos la clase de la que heredamos para que sea la clase User de Laravel.
/**
 * App\Models\Usuario
 *
 * @property int $usuario_id
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario query()
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereUsuarioId($value)
 * @mixin \Eloquent
 */
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
