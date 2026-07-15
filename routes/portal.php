<?php

use App\Http\Controllers\Portal\PortalController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->prefix('portal')->name('portal.')->group(function () {
    Route::get('/inicio', [PortalController::class, 'index'])->name('inicio');
});
