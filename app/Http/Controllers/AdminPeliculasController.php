<?php

namespace App\Http\Controllers;

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
        $peliculas = Pelicula::all();

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
        return view('admin.peliculas.nueva-form');
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

        // Si queremos todos salvo alguno que otro, podemos usar el método except().
        $data = $request->except(['_token']); // Pedimos todos salvo el token de CSRF.

//        echo "<pre>";
//        print_r($data);
//        echo "</pre>";
        // TODO: Upload de la portada...

        // Finalmente, podemos tratar de grabar.
        // Para grabar, podemos o:
        // 1. Instanciar una Pelicula, cargar las propiedades, y pedirle que se graben.
        // 2. Usar el método "static" Pelicula::create para crearlo.
        // El método create() retorna la instancia creada con los datos de la película.
        $pelicula = Pelicula::create($data);

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
        ]);
    }

    public function editarEjecutar(Request $request, int $id)
    {
        $request->validate(Pelicula::VALIDATE_RULES, Pelicula::VALIDATE_MESSAGES);

        // Buscamos la película.
        $pelicula = Pelicula::findOrFail($id);

        $data = $request->except(['_token']);

        // TODO: Upload de imagen...

        // Editamos :)
        $pelicula->update($data);

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

        // La borramos.
        $pelicula->delete();

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
