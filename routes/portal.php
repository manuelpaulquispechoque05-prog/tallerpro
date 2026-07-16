<?php

use App\Http\Controllers\Portal\CitaController;
use App\Http\Controllers\Portal\PortalController;
use App\Http\Controllers\Portal\VehiculoController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'cliente'])->prefix('portal')->name('portal.')->group(function () {
    Route::get('/inicio', [PortalController::class, 'index'])->name('inicio');

    Route::get('/vehiculos', [VehiculoController::class, 'index'])->name('vehiculos.index');
    Route::get('/vehiculos/crear', [VehiculoController::class, 'create'])->name('vehiculos.create');
    Route::post('/vehiculos', [VehiculoController::class, 'store'])->name('vehiculos.store');
    Route::get('/vehiculos/{id}', [VehiculoController::class, 'show'])->name('vehiculos.show');
    Route::get('/vehiculos/modelos-por-marca/{marcaId}', [VehiculoController::class, 'modelosPorMarca'])->name('vehiculos.modelos-por-marca');

    // Perfil
    Route::get('/perfil', [PortalController::class, 'perfil'])->name('perfil');
    Route::put('/perfil', [PortalController::class, 'perfilUpdate'])->name('perfil.update');

    // Citas
    Route::get('/citas', [CitaController::class, 'index'])->name('citas.index');
    Route::get('/citas/crear', [CitaController::class, 'create'])->name('citas.create');
    Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');
    Route::get('/citas/disponibilidad', [CitaController::class, 'disponibilidad'])->name('citas.disponibilidad');
});
