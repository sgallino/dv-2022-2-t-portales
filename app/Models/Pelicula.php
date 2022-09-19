<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pelicula
 *
 * @property int $pelicula_id
 * @property string $titulo
 * @property int $precio
 * @property string $fecha_estreno
 * @property string $descripcion
 * @property string|null $portada
 * @property string|null $portada_descripcion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereFechaEstreno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula wherePeliculaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula wherePortada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula wherePortadaDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula wherePrecio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereTitulo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Pelicula extends Model
{
//   use HasFactory;

    // Configuramos el nombre de la tabla.
    // Por defecto, Eloquent supone que estamos siguiendo las convenciones de Laravel, y va a buscar una
    // tabla que se llame igual que la clase, pero en minúsculas y en plural (del inglés).
    // Si no es así, entonces debemos configurar el nombre, como hacemos a continuación.
    protected $table = "peliculas";

    // Configuramos la PK.
    // Por defecto, Eloquent supone que estamos siguiendo las convenciones de Laravel, y que el campo de la
    // PK se llama "id".
    // Si no es así, entonces debemos configurar el nombre, como hacemos a continuación.
    protected $primaryKey = "pelicula_id";

    // $fillable es un array que debe listar las propiedades que aceptamos sean asignadas "masivamente"
    // ("mass assignment").
    // Esto es importante, para evitar que usuarios maliciosos puedan cargar datos que no deberían en las
    // peticiones de creación o edición.
    protected $fillable = ['pais_id', 'titulo', 'precio', 'fecha_estreno', 'descripcion', 'portada', 'portada_descripcion'];

    public const VALIDATE_RULES = [
//            'titulo' => ['required', 'min:2'],
        'titulo' => 'required|min:2',
        'precio' => 'required|numeric|min:0',
        'fecha_estreno' => 'required',
    ];

    public const VALIDATE_MESSAGES = [
        'titulo.required' => 'El título de la película no puede quedar vacío.',
        'titulo.min' => 'El título de la película debe tener al menos :min caracteres.',
        'precio.required' => 'El precio de la película no puede quedar vacío.',
        'precio.numeric' => 'El precio de la película debe ser un número.',
        'precio.min' => 'El precio de la película debe ser un número positivo.',
        'fecha_estreno.required' => 'La fecha de estreno no puede quedar vacía.',
    ];
}
