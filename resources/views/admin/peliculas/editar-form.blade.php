<?php
// En todas las vistas de Blade, Laravel siempre se asegura de que exista una variable llamada "$errors",
// que sea una instancia de la clase "ViewErrorBag". Esto lo hace para que no tengamos que estar preguntando
// si esa variable existe o no cada vez que queramos usar mensajes de error.
/** @var \Illuminate\Support\ViewErrorBag $errors */
/** @var \App\Models\Pelicula $pelicula */
?>
@extends('layouts.main')

@section('title', 'Editar la película ' . $pelicula->titulo)

@section('main')
    <h1 class="mb-3">Editar la Película "{{ $pelicula->titulo }}"</h1>

    @if($errors->any())
        <div class="text-danger mb-3">Hay algunos datos que no siguen el formato necesario. Por favor, revisá los campos, corregí los valores y probá de nuevo.</div>
    @endif

    <form action="{{ route('admin.peliculas.editar.ejecutar', ['id' => $pelicula->pelicula_id]) }}" method="post" enctype="multipart/form-data">
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
                value="{{ old('titulo', $pelicula->titulo) }}"
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
                value="{{ old('precio', $pelicula->precio) }}"
                @error('precio') aria-describedby="error-precio" @enderror
            >
            {{-- Usamos la directiva @error para detecta si hay un mensaje de error. Si lo hay, dentro de la directiva va a existir una variable $message con el primer mensaje de error del campo. --}}
            @error('precio')
                <div class="text-danger" id="error-precio">{{ $message }}</div>
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
                value="{{ old('fecha_estreno', $pelicula->fecha_estreno) }}"
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
            >{{ old('descripcion', $pelicula->descripcion) }}</textarea>
        </div>
        <div class="mb-3" id="portada-actual">
            <p>Portada actual</p>
            @if($pelicula->portada != null && file_exists(public_path('imgs/' . $pelicula->portada)))
                <img src="{{ url('imgs/' . $pelicula->portada) }}" alt="" class="mw-100">
            @else
                <p><i>Sin portada</i></p>
            @endif
            <p>Si no querés cambiar la portada, dejá el campo de la portada vacío.</p>
        </div>
        <div class="mb-3">
            <label for="portada" class="form-label">Portada</label>
            <input
                type="file"
                id="portada"
                name="portada"
                class="form-control"
                aria-describedby="portada-actual"
            >
        </div>
        <div class="mb-3">
            <label for="portada_descripcion" class="form-label">Descripción de la Portada</label>
            <input
                type="text"
                id="portada_descripcion"
                name="portada_descripcion"
                class="form-control"
                value="{{ old('portada_descripcion', $pelicula->portada_descripcion) }}"
            >
        </div>
        <button type="submit" class="btn btn-primary">Publicar</button>
    </form>
@endsection
