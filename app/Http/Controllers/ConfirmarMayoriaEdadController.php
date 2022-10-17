<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ConfirmarMayoriaEdadController extends Controller
{
    public function confirmarForm(int $id)
    {
        return view('confirmar-edad', [
            'pelicula' => Pelicula::findOrFail($id),
        ]);
    }

    public function confirmarEjecutar(int $id)
    {
        Session::put('mayorDeEdad', true);

//        return redirect()
//            ->route('admin.peliculas.listado')
//            ->with('status.message', 'Confirmaste que sos mayor de edad. Ya podés entrar a ver las películas que tienen esa calificación.')
//            ->with('status.type', 'success');
        return redirect()
            ->route('admin.peliculas.ver', ['id' => $id]);
    }
}
