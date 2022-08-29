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
 */
Route::get('/', [\App\Http\Controllers\HomeController::class, 'home']);

Route::get('nosotros', [\App\Http\Controllers\NosotrosController::class, 'index']);

Route::get('admin/productos', [\App\Http\Controllers\AdminPeliculasController::class, 'index']);
