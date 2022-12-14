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
    // tabla que se llame igual que la clase, pero en min??sculas y en plural (del ingl??s).
    // Si no es as??, entonces debemos configurar el nombre, como hacemos a continuaci??n.
    protected $table = "peliculas";

    // Configuramos la PK.
    // Por defecto, Eloquent supone que estamos siguiendo las convenciones de Laravel, y que el campo de la
    // PK se llama "id".
    // Si no es as??, entonces debemos configurar el nombre, como hacemos a continuaci??n.
    protected $primaryKey = "pelicula_id";

    // $fillable es un array que debe listar las propiedades que aceptamos sean asignadas "masivamente"
    // ("mass assignment").
    // Esto es importante, para evitar que usuarios maliciosos puedan cargar datos que no deber??an en las
    // peticiones de creaci??n o edici??n.
    protected $fillable = ['pais_id', 'titulo', 'precio', 'fecha_estreno', 'descripcion', 'portada', 'portada_descripcion'];

    public const VALIDATE_RULES = [
//            'titulo' => ['required', 'min:2'],
        'titulo' => 'required|min:2',
        'precio' => 'required|numeric|min:0',
        'fecha_estreno' => 'required',
    ];

    public const VALIDATE_MESSAGES = [
        'titulo.required' => 'El t??tulo de la pel??cula no puede quedar vac??o.',
        'titulo.min' => 'El t??tulo de la pel??cula debe tener al menos :min caracteres.',
        'precio.required' => 'El precio de la pel??cula no puede quedar vac??o.',
        'precio.numeric' => 'El precio de la pel??cula debe ser un n??mero.',
        'precio.min' => 'El precio de la pel??cula debe ser un n??mero positivo.',
        'fecha_estreno.required' => 'La fecha de estreno no puede quedar vac??a.',
    ];

    /*
     |--------------------------------------------------------------------------
     | Accessors & Mutators
     |--------------------------------------------------------------------------
     | Un Accessor/Mutator es una funci??n que nos permite transformar los valores
     | de un atributo del modelo al momento de leerlos o asignarlos,
     | respectivamente.
     | Tenemos que crear un m??todo con el nombre del atributo en formato
     | camelCase, y que indique en el hint del retorno la clase Attribute de
     | Eloquent.
     | El m??todo DEBE ser protected.
     */
    protected function precio(): Attribute
    {
        // Retornamos el m??todo make().
        // Este m??todo acepta 2 par??metros opcionales:
        // 1. $get. Closure. Funci??n que recibe como argumento el valor actual
        //  del atributo, y debe retornar su nuevo valor.
        // 2. $set. Closure. Funci??n que recibe como argumento el valoe que se
        //  est?? asignando, y debe retornar el valor que debe ser asignado.
//        return Attribute::make(
//            function($value) {
//                return $value / 100;
//            },
//            function($value) {
//                return $value * 100;
//            }
//        );

        // El c??digo de arriba funciona, pero no es muy claro de leer.
        // Tiene 2 problemas, podr??amos decir:
        // 1. Si no tenemos bien presente el orden de las propiedades, es f??cil confundir
        // cu??l m??todo es el de lectura (accessor/get) y cu??l el de escritura (mutator/set).
        // 2. Es un poco "boilerplatey", es decir, tiene mucho c??digo extra necesario para
        // funcionar: Escribir function($value) { return ... }

        // El primer problema, lo podr??amos resolver con comentarios. Pero es a??n mejor si
        // podemos hacerlo usando funcionalidades del lenguaje, como los "named arguments".
        // Normalmente, los argumentos se pasan a los par??metros de la funci??n en base a su
        // posici??n.
        // Por ejemplo, consideremos la funci??n de php setcookie().
        // Esta funci??n recibe 7 (!) argumentos.
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
        // httpOnly (que es el 7mo par??metro). Todos los otros par??metros no me interesan.
        // Esto requerir??a pasar a todos los valores desde el 3ro al 6to alg??n default,
        // para no modificar su comportamiento, ya que no es nuestra intenci??n. Esto
        // quedar??a, por ejemplo:
        //  setcookie('nombre', 'Juan', 0, "", "", false, true); // El ??ltimo "true" es el que cambiamos
        // Es f??cil confundirse, poner alg??n valor mal, y adem??s es inc??modo de leer. No
        // queda claro cu??les son los valores que quisimos modificar, y cu??les est??n solo
        // para poder llegar al par??metro que queremos.
        // Para mejorar notablemente nuestra experiencia en estos casos, php 8 agreg?? estos
        // "named arguments", que permiten que nosotros asociemos los argumentos a los
        // par??metros por el _nombre_ del par??metro, en vez de su posici??n (piensen algo
        // como la diferencia entre arrays secuenciales y asociativos).
        // Usando los named arguments, el setcookie podr??a cambiar a:
        //  setcookie(name: 'nombre', value: 'Juan', httponly: true);

        // El 2do problema no tiene una f??cil soluci??n, a menos que usemos las arrow
        // functions de php.
        // Las arrow functions (php 7.4+= tiene una sintaxis muy parecida a la de JS, pero
        // con algunos comportamientos particulares en php:
        // 1. No pueden tener un cuerpo de funci??n. Solo pueden retornar una expresi??n.
        // 2. Tienen autom??ticamente acceso a las variables del contexto que las contiene sin
        //  necesidad de pasarlas con el "use".
        // Sintaxis:
        // fn (parametros) => expresi??nRetorno

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
     | Para definir una relaci??n entre dos modelos de Eloquent, tenemos que crear
     | un m??todo por cada una.
     | El nombre del m??todo es importante, ya que va a servir tanto para:
     | - El "nombre" de la relaci??n (usando para referirnos a ella en ciertos
     |  lugares).
     | - El nombre de la propiedad que Eloquent va a crear para acceder a los
     |  modelos relacionados.
     | El m??todo debe retornar el tipo de relaci??n.
     */
    public function pais()
    {
        // belongsTo define una relaci??n de 1:n en la tabla referenciadora (la que lleva la FK).
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
        // belongsToMany define una relaci??n de n:m.
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
            /*->orderBy('nombre')*/; // Si quieren que vengan ordenados alfab??ticamente.
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
