<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
 * La clase Route nos permite definir "rutas" para nuestra aplicación.
 * Esto es, qué URLs pueden accederse (a partir de la carpeta public/), y con métodos de HTTP (get, post,
 * etc).
 *
 * Esta ruta que Laravel nos trae por defecto define la URL en la raíz de public ("/"), cuando se entre por
 * GET (Route::get()).
 * El segundo parámetro define la función o método de un controller que se debe encargar de procesar esa
 * petición.
 * En este ejemplo, la función lo único que hace es renderizar una vista "welcome".
 *
 * // La ruta default de Laravel
 * Route::get('/', function () {
 *     return view('welcome');
 * });
 *
 * Esta forma de definir las rutas es extremadamente versátil. Podemos crear cualquier URL que queramos,
 * para que sea lo más amigable, tanto para el usuario como para buscadores, posible. Y esto sin tener
 * ningún impacto en cómo vamos a organizar nuestro propio.
 * La contra que tiene, es que tenemos que definir las rutas manualmente en este archivo.
 */
//Route::get('/', function () {
//     ¿De dónde sale esta vista?
//     Las vistas están ubicadas en la carpeta [resources/views].
//     La función "view()" busca una vista en esa carpeta que corresponda al nombre que le pasamos, más la
//     extensión que puede ser ".blade.php" (vista que usa el motor de templates Blade de Laravel) o ".php".
//    return view('welcome');
//});
/*
 * Si bien es válido el pasar una función a la ruta para que se ejecute, en general no es una buena idea.
 * El objetivo de este archivo es el de listar las rutas. Esa es su responsabilidad.
 * Es decir, yo solo quiero tener que modificar este archivo si hay cambios en las rutas, por ejemplo,
 * hay una ruta nueva, hay que eliminar una, cambiar alguna existente. Pero no quiero tener que tocar este
 * archivo cambios en la lógica de cómo se resuelve cada vista.
 *
 * En general, preferimos siempre delegar la tarea de manejar las rutas a métodos de alguna clase de tipo
 * controller.
 *
 * Las clases de tipo controller en Laravel se suelen ubicar en la carpeta [app/Http/Controllers/].
 *
 * Vamos a migrar la ruta de la raíz para que utilice un controller llamado "HomeController".
 *
 * Una vez creado el controller con un método que renderice la vista "welcome" (llamado en nuestro caso
 * "home"), podemos registrar la ruta a ese controller pasando como segundo parámetro un array.
 * Este array debe recibir como primer valor el nombre completo (FQN) de la clase, y como segundo
 * valor el nombre del método de la clase.
 *
 * Las rutas pueden tener algunas configuraciones extras, como por ejemplo un "nombre".
 * El nombre de la ruta es algo interno (no impacta en nada el HTML generado), pero Laravel permite que
 * creemos las URLs de las rutas a partir del nombre de la misma.
 * Esto es útil porque no siempre los nombres de las URLs son "cómodos" para el desarrollo, ya que por
 * ejemplo puede pasar que queramos cambiar alguno de los segmentos de la URL. Si hacemos eso, y los links
 * estaban generados con la URL, tendríamos que actualizar todo nuestro proyecto.
 * En cambio, si lo hacemos por el nombre, solo debemos cambiar la URL en la ruta, y todo lo demás se
 * actualiza solito.
 */
Route::get('/', [\App\Http\Controllers\HomeController::class, 'home'])
    ->name('home');

Route::get('nosotros', [\App\Http\Controllers\NosotrosController::class, 'index'])
    ->name('nosotros');

/*
 |--------------------------------------------------------------------------
 | Autenticación
 |--------------------------------------------------------------------------
 */
Route::get('iniciar-sesion', [\App\Http\Controllers\AuthController::class, 'loginForm'])
    ->name('auth.login.form');
Route::post('iniciar-sesion', [\App\Http\Controllers\AuthController::class, 'loginEjecutar'])
    ->name('auth.login.ejecutar');
Route::post('cerrar-sesion', [\App\Http\Controllers\AuthController::class, 'logoutEjecutar'])
    ->name('auth.logout');

/*
 |--------------------------------------------------------------------------
 | Películas
 |--------------------------------------------------------------------------
 | Usamos un "grupo" de rutas para pedir que todo lo referente al admin de
 | películas requiera que el usuario esté autenticado.
 */
Route::middleware(['auth'])
    // Definimos el controller que va a usarse para todas estas rutas.
    ->controller(\App\Http\Controllers\AdminPeliculasController::class)
    ->group(function() {
        Route::get('admin/peliculas', 'index')
            ->name('admin.peliculas.listado');

        Route::get('admin/peliculas/papelera', 'papelera')
            ->name('admin.peliculas.papelera');

        Route::get('admin/peliculas/nueva', 'nuevaForm')
            ->name('admin.peliculas.nueva.form');

        Route::post('admin/peliculas/nueva', 'nuevaGrabar')
            ->name('admin.peliculas.nueva.grabar');

        /*
         * Por supuesto, muchas veces vamos a necesitar tener segmentos "dinámicos" en la URL (es decir, cuyo valor
         * puede variar y queremos poder capturar). Para definirlos, los escribimos con el formato {nombre}, donde
         * 'nombre' sería el nombre de la variable que queremos recibir con el valor en el método del controller.
         */
        Route::get('admin/peliculas/{id}', 'ver')
            ->name('admin.peliculas.ver')
//    ->where('id', '[0-9]+')
            ->whereNumber('id')
            ->middleware('mayor-edad');

        Route::get('admin/peliculas/{id}/editar', 'editarForm')
            ->name('admin.peliculas.editar.form')
            ->whereNumber('id');

        Route::post('admin/peliculas/{id}/editar', 'editarEjecutar')
            ->name('admin.peliculas.editar.ejecutar')
            ->whereNumber('id');


        Route::get('admin/peliculas/{id}/eliminar', 'eliminarConfirmar')
            ->name('admin.peliculas.eliminar.confirmar')
            ->whereNumber('id');

        Route::post('admin/peliculas/{id}/eliminar', 'eliminarEjecutar')
            ->name('admin.peliculas.eliminar.ejecutar')
            ->whereNumber('id');

        Route::post('admin/peliculas/{id}/eliminar-definitivamente', 'eliminarDefinitivamenteEjecutar')
            ->name('admin.peliculas.eliminar-definitivamente.ejecutar')
            ->whereNumber('id');

        Route::post('admin/peliculas/{id}/recuperar', 'recuperarEjecutar')
            ->name('admin.peliculas.recuperar.ejecutar')
            ->whereNumber('id');
    });


Route::get('peliculas/{id}/confirmar-mayoria-edad', [\App\Http\Controllers\ConfirmarMayoriaEdadController::class, 'confirmarForm'])
    ->middleware('auth')
    ->name('confirmar-mayoria-edad.form');

Route::post('peliculas/{id}/confirmar-mayoria-edad', [\App\Http\Controllers\ConfirmarMayoriaEdadController::class, 'confirmarEjecutar'])
    ->middleware('auth')
    ->name('confirmar-mayoria-edad.ejecutar');

Route::post('peliculas/{id}/reservar', [\App\Http\Controllers\ReservarPeliculaController::class, 'reservarEjecutar'])
    ->middleware('auth')
    ->name('peliculas.reservar.ejecutar');

//Route::get('admin/peliculas', [\App\Http\Controllers\AdminPeliculasController::class, 'index'])
//    ->name('admin.peliculas.listado')
//    // Restringimos el acceso a solo usuarios autenticados.
//    ->middleware(['auth']);
//
//Route::get('admin/peliculas/nueva', [\App\Http\Controllers\AdminPeliculasController::class, 'nuevaForm'])
//    ->name('admin.peliculas.nueva.form');
//
//Route::post('admin/peliculas/nueva', [\App\Http\Controllers\AdminPeliculasController::class, 'nuevaGrabar'])
//    ->name('admin.peliculas.nueva.grabar');
//
///*
// * Por supuesto, muchas veces vamos a necesitar tener segmentos "dinámicos" en la URL (es decir, cuyo valor
// * puede variar y queremos poder capturar). Para definirlos, los escribimos con el formato {nombre}, donde
// * 'nombre' sería el nombre de la variable que queremos recibir con el valor en el método del controller.
// */
//Route::get('admin/peliculas/{id}', [\App\Http\Controllers\AdminPeliculasController::class, 'ver'])
//    ->name('admin.peliculas.ver')
////    ->where('id', '[0-9]+')
//    ->whereNumber('id');
//
//Route::get('admin/peliculas/{id}/editar', [\App\Http\Controllers\AdminPeliculasController::class, 'editarForm'])
//    ->name('admin.peliculas.editar.form')
//    ->whereNumber('id');
//
//Route::post('admin/peliculas/{id}/editar', [\App\Http\Controllers\AdminPeliculasController::class, 'editarEjecutar'])
//    ->name('admin.peliculas.editar.ejecutar')
//    ->whereNumber('id');
//
//
//Route::get('admin/peliculas/{id}/eliminar', [\App\Http\Controllers\AdminPeliculasController::class, 'eliminarConfirmar'])
//    ->name('admin.peliculas.eliminar.confirmar')
//    ->whereNumber('id');
//
//Route::post('admin/peliculas/{id}/eliminar', [\App\Http\Controllers\AdminPeliculasController::class, 'eliminarEjecutar'])
//    ->name('admin.peliculas.eliminar.ejecutar')
//    ->whereNumber('id');
