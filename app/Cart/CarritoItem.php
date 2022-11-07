<?php

namespace App\Cart;

use App\Models\Pelicula;

class CarritoItem
{
    private Pelicula $pelicula;

    public function __construct(Pelicula $pelicula)
    {
        $this->pelicula = $pelicula;
    }

    public function getItem(): Pelicula
    {
        return $this->pelicula;
    }
}
