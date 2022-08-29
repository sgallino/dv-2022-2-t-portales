<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminPeliculasController extends Controller
{
    public function index()
    {
        return view('admin/peliculas/index');
    }
}
