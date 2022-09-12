<?php
/** @var \App\Models\Pelicula $pelicula */
?>
@extends('layouts.main')

@section('title', 'Eliminar la película ' . $pelicula->titulo)

@section('main')
    <section class="mb-3">
        <h1 class="mb-3">Eliminar {{ $pelicula->titulo }}</h1>

        @include('admin.peliculas._ver-data')
        {{--        <div class="row mb-3">--}}
{{--            <div class="col-6">--}}
{{--                Acá va a ir la portada...--}}
{{--            </div>--}}
{{--            <div class="col-6">--}}
{{--                <dl>--}}
{{--                    <dt>Precio</dt>--}}
{{--                    <dd>$ {{ $pelicula->precio }}</dd>--}}
{{--                    <dt>Fecha de Estreno</dt>--}}
{{--                    <dd>{{ $pelicula->fecha_estreno }}</dd>--}}
{{--                </dl>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <h2 class="mb-3">Sinopsis</h2>--}}

{{--        {{ $pelicula->descripcion }}--}}
    </section>

    <section>
        <form action="{{ route('admin.peliculas.eliminar.ejecutar', ['id' => $pelicula->pelicula_id]) }}" method="post">
            @csrf
            <h2 class="mb-3">Confirmar eliminación</h2>
            <p class="mb-3">Estás por eliminar esta película del sistema. <b>Esta acción es (por ahora) irreversible</b>. ¿Querés continuar?</p>
            <button type="submit" class="btn btn-danger">Sí, eliminar</button>
        </form>
    </section>
@endsection
