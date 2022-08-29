{{--
Extendemos/heredamos del template de layouts/main.blade.php con la directiva de Blade @extends()
Esta directiva va a reciribr como parámetro la ruta al template, partiendo de la carpeta [resources/views],
sin la extensión ".blade.php", y reemplazando las "/" por ".".

Es decir, la ruta [layouts/main.blade.php] se transforma en [layouts.main].
--}}
@extends('layouts.main')

{{--
Cuando como contenido de un @section solo queremos poner un string, entonces en vez de abrir y cerrar:
    @section('name') contenido @endsection

Podemos usar un segundo parámetro en el @section, y omitir el @endsection:

    @section('name', 'contenido')
--}}
{{--@section('title') Página Principal @endsection--}}
@section('title', 'Página Principal')

{{--
Cualquier contenido que pongamos a continuación se va a sumar al contenido del template heredado.
Por defecto, va a ponerlo _al comienzo_ del archivo, en este caso, antes del <!DOCTYPE html>.

Para que esto no ocurra, tenemos que aclarar en qué espacio cedido por el template heredado (vía la
directiva @yield) queremos ubicar nuestro código.
Esto lo logramos con la directiva @section('nombre') y @endsection
--}}
@section('main')
<h1>Hola :D</h1>
@endsection
