<?php
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Pelicula[]|\Illuminate\Pagination\LengthAwarePaginator $peliculas */
?>
@extends('layouts.main')

@section('title', 'Administración de Películas')

@section('main')
<h1 class="mb-3">Papelera de Reciclaje de Películas</h1>

<p class="mb-3">
    <a href="{{ route('admin.peliculas.listado') }}">Volver al listado</a>
</p>

{{--<section class="mb-3">
    <h2 class="mb-3">Buscador</h2>

    <form action="{{ route('admin.peliculas.listado') }}" method="get">
        <div class="mb-3">
            <label for="b-titulo" class="form-label">Título</label>
            <input type="text" id="b-titulo" name="titulo" class="form-control" value="{{ $paramsBuscar['titulo'] ?? '' }}">
        </div>
        <button class="btn btn-primary" type="submit">Buscar</button>
    </form>
</section>--}}

@if($peliculas->isNotEmpty())
<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Precio</th>
        <th>País de Origen</th>
        <th>Géneros</th>
        <th>Categoría</th>
        <th>Fecha de Estreno</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
    @foreach($peliculas as $pelicula)
    <tr>
        <td>{{ $pelicula->pelicula_id }}</td>
        <td>{{ $pelicula->titulo }}</td>
        <td>$ {{ $pelicula->precio }}</td>
        <td>{{ $pelicula->pais->abreviatura }}</td>
        <td>
            {{--@if($pelicula->generos->isNotEmpty())
                @foreach($pelicula->generos as $genero)
                    <span class="badge bg-secondary">{{ $genero->nombre }}</span>
                @endforeach
            @else
                No especificado.
            @endif--}}
            @forelse($pelicula->generos as $genero)
                <span class="badge bg-secondary">{{ $genero->nombre }}</span>
            @empty
                No especificado.
            @endforelse
        </td>
        <td>{{ $pelicula->categoria->abreviatura }}</td>
        <td>{{ $pelicula->fecha_estreno }}</td>
        <td>
            <div class="d-flex gap-1">
                <form action="{{ route('admin.peliculas.recuperar.ejecutar', ['id' => $pelicula->pelicula_id]) }}" method="post">
                    @csrf
                    <button class="btn btn-primary" type="submit">Recuperar</button>
                </form>
                <form action="{{ route('admin.peliculas.eliminar-definitivamente.ejecutar', ['id' => $pelicula->pelicula_id]) }}" method="post">
                    {{-- TODO: Esto, por supuesto, debería pedir una confirmación. --}}
                    @csrf
                    <button class="btn btn-danger" type="submit">Eliminar Definitivamente</button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

{{ $peliculas->links() }}
@else
    <p>¡Felicitaciones! No hay películas eliminadas.</p>
@endif
@endsection
