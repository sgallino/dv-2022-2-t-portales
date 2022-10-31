<?php

namespace App\Mail;

use App\Models\Pelicula;
use App\Models\Usuario;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PeliculaReservada extends Mailable
{
    use Queueable, SerializesModels;

    // Las propiedades públicas de la clase van a estar automáticamente disponibles en el template del
    // email.
    public Pelicula $pelicula;
    public Usuario $usuario;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Pelicula $pelicula, Usuario $usuario)
    {
        $this->pelicula = $pelicula;
        $this->usuario = $usuario;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('no-responder@dvpeliculas.com.ar', 'DV Películas')
            ->view('mails.pelicula-reservada');
    }
}
