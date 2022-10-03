<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function loginEjecutar(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Armamos las "credenciales" para iniciar sesión.
        // La credencial para el password _DEBE_ llamarse "password" (de la misma forma que sucede con la
        // tabla).
        $credenciales = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if(Auth::attempt($credenciales)) {
            // El usuario se autenticó con éxito.
            // Primero, vamos a seguir la recomendación de la documentación de Laravel, y regenerar la
            // sesión (su id).
            $request->session()->regenerate();

            return redirect()
                ->route('admin.peliculas.listado')
                ->with('status.message', 'Sesión iniciada con éxito. ¡Bienvenido/a de vuelta!')
                ->with('status.type', 'success');
        }

        return redirect()
            ->route('auth.login.form')
            ->withInput()
            ->with('status.message', 'Las credenciales ingresadas no coinciden con ninguno de nuestros registros.')
            ->with('status.type', 'danger');
    }

    public function logoutEjecutar(Request $request)
    {
        Auth::logout();

        // Regeneramos el id de sesión, por recomendación de Laravel.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with('status.message', 'Cerraste sesión correctamente. ¡Te esperamos pronto!')
            ->with('status.type', 'success');
    }
}
