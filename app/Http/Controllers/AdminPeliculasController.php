<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use App\Models\Pais;
use App\Models\Pelicula;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPeliculasController extends Controller
{
    public function index(Request $request)
    {
        // Le pedimos a Eloquent que traiga todas las películas, a través del modelo Pelicula.
        // Esto retorna una "Collection" de instancias Pelicula, representando los datos de la tabla.
        // Una Collection es una clase que "envuelve" un array, y brinda muchísimos métodos para interactuar
        // con él.
//        $peliculas = Pelicula::all();
        /*
         |--------------------------------------------------------------------------
         | Carga de relaciones
         |--------------------------------------------------------------------------
         | El método "all()" solo sirve cuando queremos traer _todos_ los registros
         | de una tabla, sin ninguna aclaración o requisito extra.
         | Si queremos agregar cualquier otra cosa, ya sea carga de relaciones,
         | filtros, límites de cantidad de registros, etc, tenemos que reemplazar el
         | "all()" por "get()", precedido de los nuevos requerimientos que queremos
         | que el query tenga.
         | Por ejemplo, si queremos cargar algunas relaciones definidas en el modelo,
         | podemos usar el método "with()", que recibe un string o array de strings
         | con los nombres de las relaciones que queremos cargar.
         */
        /*
         |--------------------------------------------------------------------------
         | Paginación y buscador
         |--------------------------------------------------------------------------
         | Para la paginación, como vimos en la documentación, tenemos el método
         | paginate() del query builder y Eloquent. Este método reemplaza al get(),
         | y como argumento le pasamos cuántos registros por página queremos que
         | se muestren.
         |
         | Para hacer el buscador, vamos a necesitar hacer algunas cosas más.
         | Primero, nos aseguramos de tener inyectada en el método del controller la
         | instancia de Request. Esto es necesario para obtener los datos que lleguen
         | del formulario vía el query string.
         | Segundo, vamos a necesitar separar el query en, al menos, tres partes:
         | 1. La preparación básica del query (la tabla, las relaciones, etc)
         | 2. Agregar las condiciones de búsqueda, si las hay.
         | 3. Ejecutar el query.
         */
//        $peliculas = Pelicula::with(['pais', 'generos', 'categoria'])->get();
        $builder = Pelicula::with(['pais', 'generos', 'categoria']);

        // Capturamos los parámetros de búsqueda, y vemos si tenemos que agregarlos.
        // Nota: Todo este manejo del query, incluyendo los parámetros de búsqueda, podrían ser una clase
        // aparte.

        $paramsBuscar = [
            'titulo' => $request->query('titulo') ?? null,
        ];

        if($paramsBuscar['titulo']) {
            $builder->where('titulo', 'LIKE', '%' . $paramsBuscar['titulo'] . '%');
        }

        $peliculas = $builder->paginate(2)->withQueryString();

        // Si queremos que la vista reciba algún valor, como por ejemplo la lista de películas, tenemos que
        // proveérselo a través del segundo parámetro de la función "view()", que debe ser un array
        // asociativo, donde las claves van a ser los nombres de las variables que se van a generar en la
        // vista.
        return view('admin/peliculas/index', [
            'peliculas' => $peliculas,
            'paramsBuscar' => $paramsBuscar,
        ]);
    }

    public function papelera()
    {
        // withTrashed() agrega los registros que estén marcados como eliminados.
        // onlyTrashed() solo trae los registros que estén marcados como eliminados.
        $peliculas = Pelicula::onlyTrashed()->with(['pais', 'generos', 'categoria'])->paginate(2);

        return view('admin/peliculas/papelera', [
            'peliculas' => $peliculas,
//            'paramsBuscar' => [],
        ]);
    }

    // $id va a recibir el valor del segmento dinámico de la ruta "{id}".
    public function ver(int $id)
    {
        // Para obtener un registro por su id, Laravel tiene el método de Eloquent "find()".
        // Si la película no existe, retorna null.
//        $pelicula = Pelicula::find($id);
        // Como es un requerimiento común el querer que si un registro no existe se muestre una pantalla
        // de 404, Laravel tiene un método incluido para realizar ese chequeo y renderizado del 404 de
        // manera automática con Eloquent: findOrFail().
        $pelicula = Pelicula::findOrFail($id);

        // Para las rutas de las vistas, Laravel permite (y usa en su documentación) reemplazar las "/" con
        // ".".
        return view('admin.peliculas.ver', [
            'pelicula' => $pelicula
        ]);
    }

    public function nuevaForm()
    {
        return view('admin.peliculas.nueva-form', [
            'paises' => Pais::orderBy('nombre')->get(),
            'generos' => Genero::orderBy('nombre')->get(),
        ]);
    }

    public function nuevaGrabar(Request $request)
    {
        // Para grabar, obviamente lo primero que necesitamos es obtener la data que el usuario envió.
        // Esto normalmente lo hacíamos a través de las súperglobales como $_POST.
        // Dicho esto, en general se desaconseja usar esas variables directamente.
        // ¿Por qué?
        // Por 2 razones:
        // 1. Son variables globales. Siempre tratamos de evitar trabajar con ese tipo de variables, ya que
        //  son muy difíciles de testear, son muy propensas a errores (ej: una función modifica el valor de
        //  esa variable, y jode a todo el resto).
        // 2. $_POST solo funciona para obtener datos que lleguen en el cuerpo de la petición de HTTP,
        //  con formato de formulario (campo=valor&campo2=valor2...) y si está el header correspondiente
        //  de forms en la petición.
        //  Esto excluye otras posibles situaciones de datos que lleguen por POST, como datos enviados por
        //  Ajax con formato de JSON.
        // Para resolver ambos puntos, y cualquier otra interacción con información pertinente a la petición
        // actual, Laravel nos ofrece la clase Request.
        // Para obtener la instancia, vamos a "inyectarla" como un parámetro del método.

        // Validación.
        // La clase Request tiene un método para validar llamado "validate()".
        // Este método hace varias cosas:
        // 1. Recibe como argumento obligatorio un array con las "reglas" de validación.
        //  1b. Opcionalmente, recibe un segundo parámetro con los mensajes de error para cada validación de
        //      cada campo.
        // 2. Aplica esas "reglas" sobre los datos enviados por el usuario.
        // 3. Si los datos pasan las validaciones, entonces nos retorna un array que incluye solo los datos
        //  validados.
        // 4. Si alguna regla falla, entonces:
        //  a. Si es una petición "común" (no por Ajax), entonces guarda en una variable de sesión de tipo
        //      "flash" los mensajes de error de la validación, en otra variable guarda los datos ingresados
        //      por el usuario, y finalmente, redirecciona al usuario a la página de la cual vino.
        //  b. Si es una petición de Ajax, entonces simplemente genera una respuesta en JSON con los mensajes
        //      de error de la validación.
        $request->validate(Pelicula::VALIDATE_RULES, Pelicula::VALIDATE_MESSAGES);

        // Entre los métodos que ofrece, tenemos "input()" que retorna todos los campos del form, o solo
        // los que le pidamos por parámetro.
//        $data = $request->input();

//        echo "<pre>";
//        print_r($request->input());
//        echo "</pre>";
//        exit;

        // Si queremos todos salvo alguno que otro, podemos usar el método except().
        $data = $request->except(['_token']); // Pedimos todos salvo el token de CSRF.

        if($request->hasFile('portada')) {
            $portada = $request->file('portada');
            // Generamos un nombre para la portada.
            // Esto va a ser la fecha y hora actual, seguida de un guión bajo, seguido del nombre de la
            // película convertido a un "slug".
            // Para convertir un string a un "slug", Laravel tiene un método "slug" en la clase de ayuda
            // "Str".
            $data['portada'] = date('YmdHis') . "_" . \Str::slug($data['titulo']) . "." . $portada->extension();

            // Forma 1: Guardamos el archivo en su ubicación final usando el método "move()".
            $portada->move(public_path('imgs'), $data['portada']);

            // Forma 2: Guardamos el archivo usando la API de Storage (filesystem) de Laravel.
            // El tercer parámetro es el "disco" de Laravel que queremos utilizar.
//            $portada->storeAs('imgs', $data['portada'], 'public');
        }

        // Finalmente, podemos tratar de grabar.
        // Para grabar, podemos o:
        // 1. Instanciar una Pelicula, cargar las propiedades, y pedirle que se graben.
        // 2. Usar el método "static" Pelicula::create para crearlo.
        // El método create() retorna la instancia creada con los datos de la película.


        /*
         |--------------------------------------------------------------------------
         | Alta de géneros
         |--------------------------------------------------------------------------
         | Para guardar datos de una tabla pivot, nosotros teníamos que primero hacer
         | el INSERT en la tabla principal, obtener el ID, y luego hacer un INSERT de,
         | uno por uno, todos los valores de la tabla pivot.
         | Los primeros dos pasos (el INSERT en la tabla principal y la obtención del
         | ID) lo tenemos en la línea anterior, cuando hacemos el create() y capturamos
         | el objeto creado.
         | Para hacer el alta en la tabla pivot, que si recordamos de Programación 2
         | era algo un poco engorroso, Laravel nos ofrece algunos métodos para hacer
         | nuestra vida mucho más simple.
         | https://laravel.com/docs/9.x/eloquent-relationships#updating-many-to-many-relationships
         |
         | En resumen, Eloquent tiene 3 métodos para manejar la carga de datos en
         | una tabla pivot:
         | - attach()
         | - detach()
         | - sync()
         |
         | Hablemos de "attach()".
         | Este método permite agregar uno o más IDs a la tabla pivot de una relación de
         | n:m.
         */
        try {
            DB::transaction(function() use ($data) {
                $pelicula = Pelicula::create($data);
                // Agregamos esos géneros a la película. Noten que el acceso a la relación es como _método_, y no
                // como _propiedad_.
                $generos = $data['generos'] ?? []; // Obtenemos el array de ids de géneros.
                $pelicula->generos()->attach($generos);
            });

            // Redireccionamos al listado de películas.
            return redirect()
                ->route('admin.peliculas.listado')
                // Noten que como queremos imprimir este string como HTML (evidenciado por la <b>), escapamos
                // con la función e() el título de la película para evitar la inyección de HTML.
                ->with('status.message', 'La película <b>' . e($data['titulo']) . '</b> fue creada exitosamente.')
                ->with('status.type', 'success');
        } catch(\Throwable $e) {
            // Guardamos en el Debugbar el mensaje de error.
            Debugbar::error($e);

            // En producción, probablemente querríamos guardar esto en algún log.

            return redirect()
                ->route('admin.peliculas.nueva.form')
                ->with('status.message', 'Ocurrió un error inesperado. La película <b>' . e($data['titulo']) . '</b> no pudo ser creada.')
                ->with('status.type', 'danger')
                ->withInput(); // withInput() envía los datos del form para que podamos accederlos con "old()".
        }
    }

    public function editarForm(int $id)
    {
        $pelicula = Pelicula::findOrFail($id);

        return view('admin.peliculas.editar-form', [
            'pelicula' => $pelicula,
            'paises' => Pais::orderBy('nombre')->get(),
            'generos' => Genero::orderBy('nombre')->get(),
        ]);
    }

    public function editarEjecutar(Request $request, int $id)
    {
        $request->validate(Pelicula::VALIDATE_RULES, Pelicula::VALIDATE_MESSAGES);

        // Buscamos la película.
        $pelicula = Pelicula::findOrFail($id);

        $data = $request->except(['_token']);

        if($request->hasFile('portada')) {
            $portada = $request->file('portada');
            // Generamos un nombre para la portada.
            // Esto va a ser la fecha y hora actual, seguida de un guión bajo, seguido del nombre de la
            // película convertido a un "slug".
            // Para convertir un string a un "slug", Laravel tiene un método "slug" en la clase de ayuda
            // "Str".
            $data['portada'] = date('YmdHis') . "_" . \Str::slug($data['titulo']) . "." . $portada->extension();

            // Forma 1: Guardamos el archivo en su ubicación final usando el método "move()".
            $portada->move(public_path('imgs'), $data['portada']);

            // Forma 2: Guardamos el archivo usando la API de Storage (filesystem) de Laravel.
            // El tercer parámetro es el "disco" de Laravel que queremos utilizar.
//            $portada->storeAs('imgs', $data['portada'], 'public');

            // Guardamos el nombre de la portada actual para eliminarla después si el editar tuvo éxito.
            $portadaVieja = $pelicula->portada;
        } else {
            $portadaVieja = null;
        }

        // Editamos :)
        /*
         |--------------------------------------------------------------------------
         | Géneros
         |--------------------------------------------------------------------------
         | Hacemos uso del método "sync()" de la relación (noten que accedemos al
         | _método_ de la relación, no a la _propiedad_) para actualizar los géneros.
         | sync() se encarga de dejar solamente en la tabla pivot los ids que le
         | pasemos como argumento. Si faltan, los agrega, si sobran, los elimina.
         */
        /*
         |--------------------------------------------------------------------------
         | Transacciones
         |--------------------------------------------------------------------------
         | Forma 1: Manejando la transacción "manualmente".
         */
        /*try {
            DB::beginTransaction();
            $pelicula->update($data);
            // Fingimos que algo sale mal lanzando una Exception.
//            throw new \Exception('Error simulado de la base de datos.');
            $pelicula->generos()->sync($data['generos'] ?? []);

            if($portadaVieja != null && file_exists(public_path('imgs/' . $portadaVieja))) {
                unlink(public_path('imgs/' . $portadaVieja));
    //            unlink(storage_path('public/imgs/' . $portadaVieja));
            }

            DB::commit();

            // Redireccionamos al listado de películas.
            return redirect()
                ->route('admin.peliculas.listado')
                // Noten que como queremos imprimir este string como HTML (evidenciado por la <b>), escapamos
                // con la función e() el título de la película para evitar la inyección de HTML.
                ->with('status.message', 'La película <b>' . e($pelicula->titulo) . '</b> fue actualizada exitosamente.')
                ->with('status.type', 'success');
        } catch(\Throwable $e) {
            DB::rollBack();

            // Guardamos en el Debugbar el mensaje de error.
            Debugbar::error($e);

            // En producción, probablemente querríamos guardar esto en algún log.

            return redirect()
                ->route('admin.peliculas.editar.form', ['id' => $pelicula->pelicula_id])
                ->with('status.message', 'Ocurrió un error inesperado. La película <b>' . e($pelicula->titulo) . '</b> no pudo ser actualizada.')
                ->with('status.type', 'danger')
                ->withInput(); // withInput() envía los datos del form para que podamos accederlos con "old()".
        }*/
        /*
         |--------------------------------------------------------------------------
         | Transacciones
         |--------------------------------------------------------------------------
         | Forma 2: Usando el método transaction().
         | Este método recibe un callback como parámetro con el código que queremos
         | ejecutar en la transacción. Si algo sale mal, lanza un Exception.
         | En php, las funciones no tienen acceso a las variables de los ámbitos o
         | contextos ("scopes") contenedores automáticamente, como sucede en JS.
         | Si queremos que una o más variables estén disponibles, tenemos que
         | indicarlas explícitamente con la instrucción "use".
         */
        try {
            DB::transaction(function() use ($pelicula, $data) {
                $pelicula->update($data);
                // Fingimos que algo sale mal lanzando una Exception.
//                throw new \Exception('Error simulado de la base de datos.');
                $pelicula->generos()->sync($data['generos'] ?? []);
            });

            if($portadaVieja != null && file_exists(public_path('imgs/' . $portadaVieja))) {
                unlink(public_path('imgs/' . $portadaVieja));
    //            unlink(storage_path('public/imgs/' . $portadaVieja));
            }

            // Redireccionamos al listado de películas.
            return redirect()
                ->route('admin.peliculas.listado')
                // Noten que como queremos imprimir este string como HTML (evidenciado por la <b>), escapamos
                // con la función e() el título de la película para evitar la inyección de HTML.
                ->with('status.message', 'La película <b>' . e($pelicula->titulo) . '</b> fue actualizada exitosamente.')
                ->with('status.type', 'success');
        } catch(\Throwable $e) {
            // Guardamos en el Debugbar el mensaje de error.
            Debugbar::error($e);

            // En producción, probablemente querríamos guardar esto en algún log.

            return redirect()
                ->route('admin.peliculas.editar.form', ['id' => $pelicula->pelicula_id])
                ->with('status.message', 'Ocurrió un error inesperado. La película <b>' . e($pelicula->titulo) . '</b> no pudo ser actualizada.')
                ->with('status.type', 'danger')
                ->withInput(); // withInput() envía los datos del form para que podamos accederlos con "old()".
        }
    }

    public function eliminarConfirmar(int $id)
    {
        $pelicula = Pelicula::findOrFail($id);

        return view('admin.peliculas.eliminar', [
            'pelicula' => $pelicula,
        ]);
    }

    public function eliminarEjecutar(int $id)
    {
        // Buscamos la película para verificar que en efecto existe.
        $pelicula = Pelicula::findOrFail($id);

        $portadaVieja = $pelicula->portada;

        // Borramos cualquier género que pueda haber para la película con el método "detach()".
        // Nuevamente, noten que el método lo llamamos desde el _método_ (no _propiedad_) de la relación.
//        $pelicula->generos()->detach();

        // La borramos.
        $pelicula->delete();

        if($portadaVieja != null && file_exists(public_path('imgs/' . $portadaVieja))) {
            unlink(public_path('imgs/' . $portadaVieja));
//            unlink(storage_path('public/imgs/' . $portadaVieja));
        }

        // Redireccionamos al listado de películas.
        // En cada redireccionamiento, podemos agregar variables de sesión de tipo "flash" fácilmente con
        // ayuda del método "with()".
        // Esto es muy útil para pasar, por ejemplo, mensajes de feedback.
        return redirect()
            ->route('admin.peliculas.listado')
            // Noten que como queremos imprimir este string como HTML (evidenciado por la <b>), escapamos
            // con la función e() el título de la película para evitar la inyección de HTML.
            ->with('status.message', 'La película <b>' . e($pelicula->titulo) . '</b> fue eliminada exitosamente.')
            ->with('status.type', 'success');
    }

    public function recuperarEjecutar(int $id)
    {
        Pelicula::onlyTrashed()->findOrFail($id)->restore();

        return redirect()
            ->route('admin.peliculas.papelera')
            ->with('status.type', 'success')
            ->with('status.message', 'La película fue restablecida correctamente.');
    }

    public function eliminarDefinitivamenteEjecutar(int $id)
    {
        $pelicula = Pelicula::onlyTrashed()->findOrFail($id);

        try {
            DB::transaction(function() use ($pelicula) {
                $pelicula->generos()->detach();
                $pelicula->forceDelete();
            });

            return redirect()
                ->route('admin.peliculas.papelera')
                ->with('status.type', 'success')
                ->with('status.message', 'La película fue eliminada correctamente.');
        } catch(\Throwable $e) {

            // Guardamos en el Debugbar el mensaje de error.
            Debugbar::error($e);

            // En producción, probablemente querríamos guardar esto en algún log.

            return redirect()
                ->route('admin.peliculas.papelera')
                ->with('status.message', 'Ocurrió un error inesperado. La película <b>' . e($pelicula->titulo) . '</b> no pudo ser eliminada definitivamente.')
                ->with('status.type', 'danger')
                ->withInput(); // withInput() envía los datos del form para que podamos accederlos con "old()".
        }
    }
}
