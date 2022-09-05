<?php
?>
@extends('layouts.main')

@section('title', 'Publicar una nueva película')

@section('main')
    <h1 class="mb-3">Publicar una Nueva Película</h1>

    <form action="{{ route('admin.peliculas.nueva.grabar') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" id="titulo" name="titulo" class="form-control">
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="text" id="precio" name="precio" class="form-control">
        </div>
        <div class="mb-3">
            <label for="fecha_estreno" class="form-label">Fecha de Estreno</label>
            <input type="date" id="fecha_estreno" name="fecha_estreno" class="form-control">
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="portada" class="form-label">Portada</label>
            <input type="file" id="portada" name="portada" class="form-control">
        </div>
        <div class="mb-3">
            <label for="portada_descripcion" class="form-label">Descripción de la Portada</label>
            <input type="text" id="portada_descripcion" name="portada_descripcion" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Publicar</button>
    </form>
@endsection
