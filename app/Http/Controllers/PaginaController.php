<?php

namespace App\Http\Controllers;

class PaginaController extends Controller
{
    public function nosotros()
    {
        return view('client.paginas.nosotros');
    }

    public function pagos()
    {
        return view('client.paginas.pagos');
    }

    public function contacto()
    {
        return view('client.paginas.contacto');
    }
}