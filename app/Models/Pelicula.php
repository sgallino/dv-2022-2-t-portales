<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pelicula
 *
 * @property int $pelicula_id
 * @property int $pais_id
 * @property string $titulo
 * @property int $precio
 * @property string $fecha_estreno
 * @property string $descripcion
 * @property string|null $portada
 * @property string|null $portada_descripcion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pais $pais
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula wherePaisId($value)
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Genero[] $generos
 * @property-read int|null $generos_count
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

    /*
     |--------------------------------------------------------------------------
     | Relaciones
     |--------------------------------------------------------------------------
     | Para definir una relación entre dos modelos de Eloquent, tenemos que crear
     | un método por cada una.
     | El nombre del método es importante, ya que va a servir tanto para:
     | - El "nombre" de la relación (usando para referirnos a ella en ciertos
     |  lugares).
     | - El nombre de la propiedad que Eloquent va a crear para acceder a los
     |  modelos relacionados.
     | El método debe retornar el tipo de relación.
     */
    public function pais()
    {
        // belongsTo define una relación de 1:n en la tabla referenciadora (la que lleva la FK).
        // Puede recibir los siguientes argumentos:
        // 1. String. El FQN del modelo de Eloquent que queremos relacionar.
        // 2. Opcional. String. El nombre del campo de la FK.
        // 3. Opcional. String. El nombre del campo de la PK referenciada.
        return $this->belongsTo(
            Pais::class,
            'pais_id',
            'pais_id'
        );
    }

    public function generos()
    {
        // belongsToMany define una relación de n:m.
        // Puede recibir los siguientes argumentos:
        // 1. String. El FQN del modelo de Eloquent que queremos relacionar.
        // 2. Opcional. String. El nombre de la tabla pivot.
        // 3. Opcional. String. El nombre de la FK en la tabla pivot ("foreignPivotKey").
        // 4. Opcional. String. El nombre de la PK de la tabla relacionada en la tabla pivot ("relatedPivotKey").
        // 5. Opcional. String. El nombre de la PK de esta tabla ("parentKey").
        // 6. Opcional. String. El nombre de la PK de la tabla relacionada ("relatedKey").
        return $this->belongsToMany(
            Genero::class,
            'peliculas_tienen_generos',
            'pelicula_id',
            'genero_id',
            'pelicula_id',
            'genero_id'
        )
            /*->orderBy('nombre')*/; // Si quieren que vengan ordenados alfabéticamente.
    }

    /*
     |--------------------------------------------------------------------------
     | Helpers
     |--------------------------------------------------------------------------
     */
    public function getGenerosIds()
    {
        return $this->generos->pluck('genero_id')->toArray();
    }
}
