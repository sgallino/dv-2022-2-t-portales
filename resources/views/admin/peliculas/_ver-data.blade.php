<?php
/** @var \App\Models\Pelicula $pelicula */
?>
<div class="row mb-3">
    <div class="col-4">
        {{-- Forma 1: Usando carpeta en public. --}}
        @if($pelicula->portada != null && file_exists(public_path('imgs/' . $pelicula->portada)))
        <img src="{{ url('imgs/' . $pelicula->portada) }}" alt="{{ $pelicula->portada_descripcion }}" class="mw-100">
        {{-- Forma 2: Usando la API Storage.
         Importante: Los links generados con Storage::url() usan la ruta de base definida en el archivo
         de configuración [config/filesystems.php].
         --}}
{{--        @if($pelicula->portada != null && Storage::disk('public')->has('imgs/' . $pelicula->portada))--}}
{{--            <img src="{{ Storage::disk('public')->url('imgs/' . $pelicula->portada) }}" alt="{{ $pelicula->portada_descripcion }}" class="mw-100">--}}
        @else
            Sin portada (Acá mostraríamos una imagen genérica que diga que no hay portada).
        @endif
    </div>
    <div class="col-8">
        <dl>
            <dt>Precio</dt>
            <dd>$ {{ $pelicula->precio }}</dd>
            <dt>País de Origen</dt>
            <dd>{{ $pelicula->pais->nombre }} ({{ $pelicula->pais->abreviatura }})</dd>
            <dt>Géneros</dt>
            <dd>
                @forelse($pelicula->generos as $genero)
                    <span class="badge bg-secondary">{{ $genero->nombre }}</span>
                @empty
                    No especificado.
                @endforelse
            </dd>
            <dt>Fecha de Estreno</dt>
            <dd>{{ $pelicula->fecha_estreno }}</dd>
        </dl>

        <h2 class="mb-3">Sinopsis</h2>

        {{ $pelicula->descripcion }}
    </div>
</div>
