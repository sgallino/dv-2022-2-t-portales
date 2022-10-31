<?php
/** @var \App\Models\Pelicula $pelicula */
/** @var \App\Models\Usuario $usuario */
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Confirmación de Reserva de Película</title>
</head>
<body>
    <h1>Reserva de la Película <b>{{ $pelicula->titulo }}</b></h1>

    <p>¡Hola <i>{{ $usuario->email }}</i>! Este correo es para confirmar que tu reserva de la película <b>{{ $pelicula->titulo }}</b> se registró con éxito.</p>

    <p>Blah blah blah, iquirish maquirish.</p>

    <p>
        Saludos,<br>
        tus amigos de DV Películas.
    </p>
</body>
</html>
