<?php
// En todas las vistas de Blade, Laravel siempre se asegura de que exista una variable llamada "$errors",
// que sea una instancia de la clase "ViewErrorBag". Esto lo hace para que no tengamos que estar preguntando
// si esa variable existe o no cada vez que queramos usar mensajes de error.
/** @var \Illuminate\Support\ViewErrorBag $errors */
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Pais[] $paises */
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Genero[] $generos */
?>
@extends('layouts.main')

@section('title', 'Publicar una nueva película')

@section('main')
    <h1 class="mb-3">Publicar una Nueva Película</h1>

    @if($errors->any())
        <div class="text-danger mb-3">Hay algunos datos que no siguen el formato necesario. Por favor, revisá los campos, corregí los valores y probá de nuevo.</div>
    @endif

    <form action="{{ route('admin.peliculas.nueva.grabar') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label
                for="titulo"
                class="form-label @if($errors->has('titulo')) text-danger @endif"
            >Título</label>
            <input
                type="text"
                id="titulo"
                name="titulo"
                class="form-control @if($errors->has('titulo')) is-invalid mb-1 @endif"
                value="{{ old('titulo') }}"
                @if($errors->has('titulo')) aria-describedby="error-titulo" @endif
            >
            {{-- Agregamos el mensaje de error para este campo, si es que existe. --}}
            @if($errors->has('titulo'))
                <div class="text-danger" id="error-titulo">{{ $errors->first('titulo') }}</div>
            @endif
        </div>
        <div class="mb-3">
            <label
                for="precio"
                class="form-label @error('precio') text-danger @enderror"
            >Precio</label>
            <input
                type="text"
                id="precio"
                name="precio"
                class="form-control @error('precio') is-invalid mb-1 @enderror"
                value="{{ old('precio') }}"
                @error('precio') aria-describedby="error-precio" @enderror
            >
            {{-- Usamos la directiva @error para detecta si hay un mensaje de error. Si lo hay, dentro de la directiva va a existir una variable $message con el primer mensaje de error del campo. --}}
            @error('precio')
                <div class="text-danger" id="error-precio">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label
                for="pais_id"
                class="form-label @error('pais_id') text-danger @enderror"
            >País de Origen</label>
            <select
                id="pais_id"
                name="pais_id"
                class="form-control @error('pais_id') is-invalid mb-1 @enderror"
                @error('pais_id') aria-describedby="error-pais_id" @enderror
            >
            @foreach($paises as $pais)
                <option
                    value="{{ $pais->pais_id }}"
{{--                    @if($pais->pais_id == old('pais_id')) selected @endif--}}
                    @selected($pais->pais_id == old('pais_id'))
                >
                    {{ $pais->nombre }}
                </option>
            @endforeach
            </select>
            @error('pais_id')
            <div class="text-danger" id="error-pais_id">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label
                for="fecha_estreno"
                class="form-label @error('fecha_estreno') text-danger @enderror"
            >Fecha de Estreno</label>
            <input
                type="date"
                id="fecha_estreno"
                name="fecha_estreno"
                class="form-control @error('fecha_estreno') is-invalid mb-1 @enderror"
                value="{{ old('fecha_estreno') }}"
                @error('fecha_estreno') aria-describedby="error-fecha_estreno" @enderror
            >
            {{-- Usamos la directiva @error para detecta si hay un mensaje de error. Si lo hay, dentro de la directiva va a existir una variable $message con el primer mensaje de error del campo. --}}
            @error('fecha_estreno')
            <div class="text-danger" id="error-fecha_estreno">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea
                id="descripcion"
                name="descripcion"
                class="form-control"
            >{{ old('descripcion') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="portada" class="form-label">Portada</label>
            <input
                type="file"
                id="portada"
                name="portada"
                class="form-control"
            >
        </div>
        <div class="mb-3">
            <label for="portada_descripcion" class="form-label">Descripción de la Portada</label>
            <input
                type="text"
                id="portada_descripcion"
                name="portada_descripcion"
                class="form-control"
                value="{{ old('portada_descripcion') }}"
            >
        </div>

        <fieldset class="mb-3">
            <legend>Géneros</legend>

            @foreach($generos as $genero)
            <div class="form-check form-check-inline">
                <input
                    type="checkbox"
                    class="form-check-input"
                    id="genero-{{ $genero->genero_id }}"
                    name="generos[]"
                    value="{{ $genero->genero_id }}"
{{--                    @if(in_array($genero->genero_id, old('generos'))) checked @endif--}}
                    @checked(in_array($genero->genero_id, old('generos', [])))
{{--                    @checked(old('generos') !== null && in_array($genero->genero_id, old('generos')))--}}
                >
                <label for="genero-{{ $genero->genero_id }}" class="form-check-label">{{ $genero->nombre }}</label>
            </div>
            @endforeach
        </fieldset>

        <button type="submit" class="btn btn-primary">Publicar</button>
    </form>
@endsection
