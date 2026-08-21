<?php

namespace App\Http\Controllers;

use App\Models\Servicio;

class HomeController extends Controller
{
    public function index()
    {
        $servicios = Servicio::with('imagenes')
            ->where('estado', true)
            ->orderBy('nombre')
            ->take(6)
            ->get();

        return view('home', compact('servicios'));
    }

    public function servicios()
    {
        $servicios = Servicio::with('imagenes')
            ->where('estado', true)
            ->orderBy('nombre')
            ->get();

        return view('servicios.publico', compact('servicios'));
    }

    public function contacto()
    {
        return view('servicios.contacto');
    }
}