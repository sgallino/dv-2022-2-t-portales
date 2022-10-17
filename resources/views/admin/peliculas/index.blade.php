<?php
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Pelicula[] $peliculas */
?>
@extends('layouts.main')

@section('title', 'Administración de Películas')

@section('main')
<h1 class="mb-3">Administración de Películas</h1>

<p class="mb-3">
    <a href="{{ route('admin.peliculas.nueva.form') }}">Publicar una nueva película</a>
</p>

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
            <a href="{{ route('admin.peliculas.ver', ['id' => $pelicula->pelicula_id]) }}" class="btn btn-primary">Ver</a>
            <a href="{{ route('admin.peliculas.editar.form', ['id' => $pelicula->pelicula_id]) }}" class="btn btn-secondary">Editar</a>
            <a href="{{ route('admin.peliculas.eliminar.confirmar', ['id' => $pelicula->pelicula_id]) }}" class="btn btn-danger">Eliminar</a>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@endsection
