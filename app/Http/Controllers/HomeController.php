<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{
    public function home()
    {
        // ¿De dónde sale esta vista?
        // Las vistas están ubicadas en la carpeta [resources/views].
        // La función "view()" busca una vista en esa carpeta que corresponda al nombre que le pasamos, más
        // la extensión que puede ser ".blade.php" (vista que usa el motor de templates Blade de Laravel) o
        // ".php".
        return view('welcome');
    }
}
