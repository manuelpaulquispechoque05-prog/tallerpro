<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RUTAS PUBLICAS
|--------------------------------------------------------------------------
| Landing page y redireccion del dashboard antiguo
|--------------------------------------------------------------------------
*/

// Landing Page — portada principal del sistema
Route::get('/', function () {
    return view('welcome');
});

// Ruta creada para el trabajo grupal (Xoce)
Route::get('/xoce', [\App\Http\Controllers\XoceController::class, 'index'])->name('xoce.index');

// Redireccion del dashboard de Breeze al nuevo panel administrativo
Route::redirect('/dashboard', '/panel/dashboard')->name('dashboard');

/*
|--------------------------------------------------------------------------
| RUTAS DE AUTENTICACION (Breeze + Google OAuth)
|--------------------------------------------------------------------------
| Login, registro, recuperacion de contrasena y login con Google.
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| RUTAS DEL PANEL ADMINISTRATIVO
|--------------------------------------------------------------------------
| Dashboard, perfil de usuario y modulos del taller.
| Todas requieren autenticacion y verificacion de correo.
|--------------------------------------------------------------------------
*/
require __DIR__.'/panel.php';

/*
|--------------------------------------------------------------------------
| RUTAS DE PERFIL DE USUARIO (BREEZE)
|--------------------------------------------------------------------------
| Edicion de nombre, correo, contrasena y eliminacion de cuenta.
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| RUTAS DEL PORTAL DEL CLIENTE (VERSION TEMPORAL)
|--------------------------------------------------------------------------
| Mientras se desarrolla el modulo completo, redirige a una vista placeholder.
|--------------------------------------------------------------------------
*/
require __DIR__.'/portal.php';
