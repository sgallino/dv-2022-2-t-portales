<?php

namespace App\Http\Middleware;

use App\Models\Pelicula;
use Closure;
use Illuminate\Http\Request;

/*
 * Los middlewares, como podemos observar, son clases comunes y corrientes.
 * Solo requieren tener un método "handle()" que reciba 2 parámetros:
 * 1. Request. Nos brinda la instancia con la data de la petición (igual que el Request de los controllers).
 * 2. Closure. Función que ejecuta el siguiente paso del proceso. Por ejemplo, pasárselo al siguiente
 *  middleware.
 *
 * Debe retornar una respuesta de HTTP o un redireccionamiento.
 *
 * Si queremos que un middleware cancele una ejecución, solamente debemos retornar un redireccionamiento a
 * otra página.
 */
class EsMayorDeEdad
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Preguntamos si el usuario indicó que es mayor de edad.
        // Este valor se va a asignar a través de un formulario que pida al usuario que confirme que es
        // mayor de edad. Al hacerlo, vamos a setear una variable de sesión "mayorDeEdad" en true.

        // Preguntamos si la película tiene una categoría de para mayores de 18 años.
        // Si la tiene, y el usuario no es mayor de edad, entonces lo redirigimos al form para que confirme
        // su mayoría de edad.
        // Para obtener la película, necesitamos obtener el parámetro de la ruta $id.
        // Como la ruta forma parte de la petición en Laravel, podemos obtener este dato desde la instancia
        // de Request.
        $id = $request->route()->parameter('id');
        $pelicula = Pelicula::findOrFail($id);
        if($pelicula->categoria_id == 4 && !\Session::has('mayorDeEdad')) {
            return redirect()->route('confirmar-mayoria-edad.form', ['id' => $id]);
        }

        // Que siga su camino.
        return $next($request);
    }
}
