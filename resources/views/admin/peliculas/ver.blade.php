<?php
/** @var \App\Models\Pelicula $pelicula */
?>
@extends('layouts.main')

@section('title', e($pelicula->titulo))

@section('main')
    <section>
        <h1 class="mb-3">{{ $pelicula->titulo }}</h1>

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
@endsection
