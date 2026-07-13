<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RUTAS DEL PORTAL DEL CLIENTE
|--------------------------------------------------------------------------
| Prefix: /portal
| Nombre: portal.*
| Middleware: auth
|
| Estas rutas se habilitaran cuando desarrollemos el modulo del portal
| para que los clientes puedan reservar citas, consultar ordenes, etc.
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('portal')->name('portal.')->group(function () {
    //
});
