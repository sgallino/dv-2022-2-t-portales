<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use App\Models\Pais;
use App\Models\Pelicula;
use Illuminate\Http\Request;

class AdminPeliculasController extends Controller
{
    public function index()
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
        $peliculas = Pelicula::with(['pais', 'generos'])->get();


        // Si queremos que la vista reciba algún valor, como por ejemplo la lista de películas, tenemos que
        // proveérselo a través del segundo parámetro de la función "view()", que debe ser un array
        // asociativo, donde las claves van a ser los nombres de las variables que se van a generar en la
        // vista.
        return view('admin/peliculas/index', [
            'peliculas' => $peliculas,
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
        $pelicula = Pelicula::create($data);

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
        $generos = $data['generos'] ?? []; // Obtenemos el array de ids de géneros.

        // Agregamos esos géneros a la película. Noten que el acceso a la relación es como _método_, y no
        // como _propiedad_.
        $pelicula->generos()->attach($generos);

        // Redireccionamos al listado de películas.
        return redirect()
            ->route('admin.peliculas.listado')
            // Noten que como queremos imprimir este string como HTML (evidenciado por la <b>), escapamos
            // con la función e() el título de la película para evitar la inyección de HTML.
            ->with('status.message', 'La película <b>' . e($pelicula->titulo) . '</b> fue creada exitosamente.')
            ->with('status.type', 'success');
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
        $pelicula->update($data);

        /*
         |--------------------------------------------------------------------------
         | Géneros
         |--------------------------------------------------------------------------
         | Hacemos uso del método "sync()" de la relación (noten que accedemos al
         | _método_ de la relación, no a la _propiedad_) para actualizar los géneros.
         | sync() se encarga de dejar solamente en la tabla pivot los ids que le
         | pasemos como argumento. Si faltan, los agrega, si sobran, los elimina.
         | TODO: Transacciones.
         */
        $pelicula->generos()->sync($data['generos'] ?? []);

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
        $pelicula->generos()->detach();

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
}
