<?php
/** @param \Illuminate\Support\ViewErrorBag $errors */
?>
@extends('layouts.main')

@section('title', 'Iniciar Sesión')

@section('main')
    <section class="mb-3">
        <h1 class="mb-3">Iniciar Sesión</h1>

        <form action="{{ route('auth.login.ejecutar') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', '') }}"
                    @error('email') aria-describedby="email-error" @enderror
                >
            </div>
            @error('email')
            <div class="mb-3 text-danger"><span class="visually-hidden">Error:</span> {{ $message }}</div>
            @enderror
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control @error('password') is-invalid @enderror"
                >
            </div>
            @error('password')
            <div class="mb-3 text-danger"><span class="visually-hidden">Error:</span> {{ $message }}</div>
            @enderror
            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
        </form>
    </section>
@endsection
