<?php

namespace App\Http\Controllers;

use App\Mail\PeliculaReservada;
use App\Models\Pelicula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReservarPeliculaController extends Controller
{
    public function reservarEjecutar(Request $request, int $id)
    {
        $pelicula = Pelicula::findOrFail($id);
        // ... reserva de la película

        // Hacemos el envío del email con la façade de Mail.
        // En el método "to()" podemos poner el email al que queremos mandar el correo, o podemos
        // pasarle directamente la instancia de la clase Usuario que queramos. Puede ser cualquier
        // clase, mientras que tenga los campos "email" y "name" (este último opcional).
        // Pasamos el usuario autenticado.
        Mail::to($request->user())
            // send() envía el email, usando la instancia de una clase Mailable que pasemos por
            // parámetro.
            ->send(new PeliculaReservada($pelicula, $request->user()));

        return redirect()
            ->route('admin.peliculas.listado')
            ->with('status.message', 'Tu reserva de la película <b>' . e($pelicula->titulo) . '</b> fue registrada con éxito.')
            ->with('status.type', 'success');
    }
}
