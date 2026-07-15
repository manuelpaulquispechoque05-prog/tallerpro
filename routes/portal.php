<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->prefix('portal')->name('portal.')->group(function () {
    Route::get('/inicio', function () {
        return view('portal.temporal');
    })->name('inicio');
});
