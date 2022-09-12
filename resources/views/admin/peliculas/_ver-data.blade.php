<?php
/** @var \App\Models\Pelicula $pelicula */
?>
<div class="row mb-3">
    <div class="col-6">
        Acá va a ir la portada...
    </div>
    <div class="col-6">
        <dl>
            <dt>Precio</dt>
            <dd>$ {{ $pelicula->precio }}</dd>
            <dt>Fecha de Estreno</dt>
            <dd>{{ $pelicula->fecha_estreno }}</dd>
        </dl>
    </div>
</div>

<h2 class="mb-3">Sinopsis</h2>

{{ $pelicula->descripcion }}
