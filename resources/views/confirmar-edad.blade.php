<?php
/** @var \App\Models\Pelicula $pelicula */
?>

@extends('layouts.main')

@section('title', 'Para continuar es necesario confirmar que sos mayor de edad')

@section('main')
    <h1 class="mb-3">Confirmación Necesaria</h1>

    <p class="mb3-">Para poder ver <b>{{ $pelicula->titulo }}</b>, es necesario que confirmes que tenés más de 18 años.</p>

    <form action="{{ route('confirmar-mayoria-edad.ejecutar', ['id' => $pelicula->pelicula_id]) }}" method="post">
        @csrf
        <a href="{{ route('admin.peliculas.listado') }}" class="btn btn-danger">No soy mayor de edad. ¡Sacame de acá!</a>
        <button type="submit" class="btn btn-primary">Sí, tengo más de 18 años</button>
    </form>
@endsection
