<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Pelicula
 *
 * @property int $pelicula_id
 * @property int $pais_id
 * @property int $categoria_id
 * @property string $titulo
 * @property int $precio
 * @property string $fecha_estreno
 * @property string $descripcion
 * @property string|null $portada
 * @property string|null $portada_descripcion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pais $pais
 * @property-read \App\Models\Categoria $categoria
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Genero[] $generos
 * @property-read int|null $generos_count
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereCategoriaId($value)
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
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|Pelicula onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Pelicula withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Pelicula withoutTrashed()
 */
class Pelicula extends Model
{
//   use HasFactory;
    use SoftDeletes;

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
     | Accessors & Mutators
     |--------------------------------------------------------------------------
     | Un Accessor/Mutator es una función que nos permite transformar los valores
     | de un atributo del modelo al momento de leerlos o asignarlos,
     | respectivamente.
     | Tenemos que crear un método con el nombre del atributo en formato
     | camelCase, y que indique en el hint del retorno la clase Attribute de
     | Eloquent.
     | El método DEBE ser protected.
     */
    protected function precio(): Attribute
    {
        // Retornamos el método make().
        // Este método acepta 2 parámetros opcionales:
        // 1. $get. Closure. Función que recibe como argumento el valor actual
        //  del atributo, y debe retornar su nuevo valor.
        // 2. $set. Closure. Función que recibe como argumento el valoe que se
        //  está asignando, y debe retornar el valor que debe ser asignado.
//        return Attribute::make(
//            function($value) {
//                return $value / 100;
//            },
//            function($value) {
//                return $value * 100;
//            }
//        );

        // El código de arriba funciona, pero no es muy claro de leer.
        // Tiene 2 problemas, podríamos decir:
        // 1. Si no tenemos bien presente el orden de las propiedades, es fácil confundir
        // cuál método es el de lectura (accessor/get) y cuál el de escritura (mutator/set).
        // 2. Es un poco "boilerplatey", es decir, tiene mucho código extra necesario para
        // funcionar: Escribir function($value) { return ... }

        // El primer problema, lo podríamos resolver con comentarios. Pero es aún mejor si
        // podemos hacerlo usando funcionalidades del lenguaje, como los "named arguments".
        // Normalmente, los argumentos se pasan a los parámetros de la función en base a su
        // posición.
        // Por ejemplo, consideremos la función de php setcookie().
        // Esta función recibe 7 (!) argumentos.
        //  setcookie(
        //    string $name,
        //    string $value = "",
        //    int $expires_or_options = 0,
        //    string $path = "",
        //    string $domain = "",
        //    bool $secure = false,
        //    bool $httponly = false
        //  ): bool
        // Supongamos que necesitamos definir una cookie, con su valor y nombre, y que sea
        // httpOnly (que es el 7mo parámetro). Todos los otros parámetros no me interesan.
        // Esto requeriría pasar a todos los valores desde el 3ro al 6to algún default,
        // para no modificar su comportamiento, ya que no es nuestra intención. Esto
        // quedaría, por ejemplo:
        //  setcookie('nombre', 'Juan', 0, "", "", false, true); // El último "true" es el que cambiamos
        // Es fácil confundirse, poner algún valor mal, y además es incómodo de leer. No
        // queda claro cuáles son los valores que quisimos modificar, y cuáles están solo
        // para poder llegar al parámetro que queremos.
        // Para mejorar notablemente nuestra experiencia en estos casos, php 8 agregó estos
        // "named arguments", que permiten que nosotros asociemos los argumentos a los
        // parámetros por el _nombre_ del parámetro, en vez de su posición (piensen algo
        // como la diferencia entre arrays secuenciales y asociativos).
        // Usando los named arguments, el setcookie podría cambiar a:
        //  setcookie(name: 'nombre', value: 'Juan', httponly: true);

        // El 2do problema no tiene una fácil solución, a menos que usemos las arrow
        // functions de php.
        // Las arrow functions (php 7.4+= tiene una sintaxis muy parecida a la de JS, pero
        // con algunos comportamientos particulares en php:
        // 1. No pueden tener un cuerpo de función. Solo pueden retornar una expresión.
        // 2. Tienen automáticamente acceso a las variables del contexto que las contiene sin
        //  necesidad de pasarlas con el "use".
        // Sintaxis:
        // fn (parametros) => expresiónRetorno

//        $centavos = 100;
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }


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

    public function categoria()
    {
        return $this->belongsTo(
            Categoria::class,
            'categoria_id',
            'categoria_id',
        );
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
