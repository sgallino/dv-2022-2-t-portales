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

    public function nuevaForm()
    {
        return view('admin/peliculas/nueva-form');
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

        // Entre los métodos que ofrece, tenemos "input()" que retorna todos los campos del form, o solo
        // los que le pidamos por parámetro.
//        $data = $request->input();

        // Si queremos todos salvo alguno que otro, podemos usar el método except().
        $data = $request->except(['_token']); // Pedimos todos salvo el token de CSRF.

//        echo "<pre>";
//        print_r($data);
//        echo "</pre>";
        // TODO: Validar y upload de la portada...

        // Finalmente, podemos tratar de grabar.
        // Para grabar, podemos o:
        // 1. Instanciar una Pelicula, cargar las propiedades, y pedirle que se graben.
        // 2. Usar el método "static" Pelicula::create para crearlo.
        Pelicula::create($data);

        // Redireccionamos al listado de películas.
        return redirect()->route('admin.peliculas.listado');
    }
}
