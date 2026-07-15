<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $cliente = $user?->cliente;

        $cliente?->loadMissing(['vehiculos', 'citas', 'ordenesTrabajo']);

        return view('portal.dashboard', compact('user', 'cliente'));
    }
}
