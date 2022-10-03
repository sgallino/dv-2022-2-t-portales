{{--
Este es un comentario de Blade.

Este archivo de layout vamos a usarlo de base para las otras vistas.
Parecido al rol que cumplió en Programación II el archivo de [index.php], pero con una importante mejora:
No va a ser este layout el que diga qué se carga en su interior.
Sino que cada vista va a poder decidir independientemente qué layout de base utilizar.

Lo único que este template debe hacer, es definir dónde pueden ubicarse contenidos.
Para hacer esto, tenemos una directiva de Blade llamada @yield() ("ceder").
Esta directive permite "donar" o "ceder" un espacio del template para que las vistas que lo extiendan o
hereden pueda volcar su contenido. Como parámetro, debe llevar un nombre identificador.


Blade tiene también elementos diseñados para la impresión de contenido.
Hay 2 que vale la pena saber ahora:

Las doble llaves imprime el contenido que escribamos en su interior, pasándolo por la función de php
htmlspecialchars.
Es decir, esto:
    {{ 'Hola mundo!' }}
Es equivalente a esto:
    <?= htmlspecialchars('Hola mundo!');?>

Laravel funciona así con el fin de protegernos automáticamente de posibles ataques de inyección de HTML.

Sin embargo, hay casos donde necesitamos imprimir código HTML con php.
Para estos casos, Laravel nos ofrece la etiqueta: {!!  !!}

Escribir:
    {!! '<b>Hola mundo!</b>' !!}
Es idéntico a escribir:
    <?= '<b>Hola mundo!</b>';?>
--}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') :: DV Películas</title>

    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/estilos.css') }}">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">DV Películas</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Abrir/cerrar menú de navegación">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">Home</a>
                            <!-- <a class="nav-link active" aria-current="page" href="#">Home</a> -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('nosotros') }}">Nosotros</a>
                        </li>
{{--                        @if(Auth::check())--}}
                        @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.peliculas.listado') }}">Admin Películas</a>
                        </li>
                        <li class="nav-item">
{{--                            <a class="nav-link" href="{{ route('auth.logout') }}">Cerrar Sesión</a>--}}
                            <form action="{{ route('auth.logout') }}" method="post">
                                @csrf
                                <button type="submit" class="btn">Cerrar Sesión ({{ Auth::user()->email }})</button>
                            </form>
                        </li>
                        @elseguest
{{--                        @else--}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('auth.login.form') }}">Iniciar Sesión</a>
                        </li>
                        @endauth
{{--                        @endif--}}
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container py-4">
            {{-- Mensajes de estado --}}
            {{-- Para acceder a variables de sesión de Laravel, usamos la fachada "Session". --}}
            @if(Session::has('status.message'))
            <div class="alert alert-{{ Session::get('status.type') ?? 'info' }} mb-4">{!! Session::get('status.message') !!}</div>
            @endif

            <section>
                @yield('main')
            </section>
        </main>

        <footer class="footer">
            <p>Da Vinci &copy; 2022</p>
        </footer>
    </div>
</body>
</html>
