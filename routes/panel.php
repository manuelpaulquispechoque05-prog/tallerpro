<?php

use App\Http\Controllers\Panel\CategoriaRepuestoController;
use App\Http\Controllers\Panel\CitaController;
use App\Http\Controllers\Panel\ClienteController;
use App\Http\Controllers\Panel\DashboardController;
use App\Http\Controllers\Panel\EspecialidadController;
use App\Http\Controllers\Panel\InventarioController;
use App\Http\Controllers\Panel\MecanicoController;
use App\Http\Controllers\Panel\OrdenTrabajoController;
use App\Http\Controllers\Panel\ProfileController;
use App\Http\Controllers\Panel\ProveedorController;
use App\Http\Controllers\Panel\RepuestoController;
use App\Http\Controllers\Panel\SucursalController;
use App\Http\Controllers\Panel\VehiculoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RUTAS DEL PANEL ADMINISTRATIVO
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->prefix('panel')->name('panel.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/perfil', [ProfileController::class, 'index'])->name('perfil');

    // ─── MODULOS RESTRINGIDOS A ADMINISTRADOR ──────────────────────────
    Route::middleware('admin')->group(function () {

        Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
        Route::get('/clientes/crear', [ClienteController::class, 'create'])->name('clientes.create');
        Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
        Route::get('/clientes/{cliente}', [ClienteController::class, 'show'])->name('clientes.show');
        Route::get('/clientes/{cliente}/editar', [ClienteController::class, 'edit'])->name('clientes.edit');
        Route::put('/clientes/{cliente}', [ClienteController::class, 'update'])->name('clientes.update');
        Route::delete('/clientes/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');

        Route::get('/vehiculos', [VehiculoController::class, 'index'])->name('vehiculos.index');
        Route::get('/vehiculos/crear', [VehiculoController::class, 'create'])->name('vehiculos.create');
        Route::post('/vehiculos', [VehiculoController::class, 'store'])->name('vehiculos.store');
        Route::get('/vehiculos/modelos-por-marca/{marcaId}', [VehiculoController::class, 'modelosPorMarca'])->name('vehiculos.modelos-por-marca');
        Route::get('/vehiculos/buscar-clientes', [VehiculoController::class, 'buscarClientes'])->name('vehiculos.buscar-clientes');
        Route::get('/vehiculos/{vehiculo}', [VehiculoController::class, 'show'])->name('vehiculos.show');
        Route::get('/vehiculos/{vehiculo}/editar', [VehiculoController::class, 'edit'])->name('vehiculos.edit');
        Route::put('/vehiculos/{vehiculo}', [VehiculoController::class, 'update'])->name('vehiculos.update');
        Route::delete('/vehiculos/{vehiculo}', [VehiculoController::class, 'destroy'])->name('vehiculos.destroy');

        Route::get('/citas', [CitaController::class, 'index'])->name('citas.index');
        Route::get('/citas/{cita}', [CitaController::class, 'show'])->name('citas.show');
        Route::get('/citas/{cita}/confirmar', [CitaController::class, 'confirmar'])->name('citas.confirmar');
        Route::post('/citas/{cita}/asignar-mecanico', [CitaController::class, 'asignarMecanico'])->name('citas.asignar-mecanico');
        Route::get('/citas/{cita}/cancelar', [CitaController::class, 'cancelar'])->name('citas.cancelar');


    Route::get('/ordenes', [OrdenTrabajoController::class, 'index'])->name('ordenes.index');
    Route::get('/ordenes/{orden}', [OrdenTrabajoController::class, 'show'])->name('ordenes.show');

    // Acciones sobre ordenes
    Route::post('/ordenes/{orden}/servicios', [OrdenTrabajoController::class, 'agregarServicio'])->name('ordenes.servicios.store');
    Route::delete('/ordenes/{orden}/servicios/{detalle}', [OrdenTrabajoController::class, 'quitarServicio'])->name('ordenes.servicios.destroy');
    Route::post('/ordenes/{orden}/repuestos', [OrdenTrabajoController::class, 'agregarRepuesto'])->name('ordenes.repuestos.store');
    Route::delete('/ordenes/{orden}/repuestos/{detalle}', [OrdenTrabajoController::class, 'quitarRepuesto'])->name('ordenes.repuestos.destroy');
    Route::post('/ordenes/{orden}/iniciar', [OrdenTrabajoController::class, 'iniciar'])->name('ordenes.iniciar');
    Route::post('/ordenes/{orden}/completar', [OrdenTrabajoController::class, 'completar'])->name('ordenes.completar');
    Route::post('/ordenes/{orden}/cancelar', [OrdenTrabajoController::class, 'cancelar'])->name('ordenes.cancelar');

        Route::get('/repuestos', [RepuestoController::class, 'index'])->name('repuestos.index');
        Route::get('/repuestos/crear', [RepuestoController::class, 'create'])->name('repuestos.create');
        Route::post('/repuestos', [RepuestoController::class, 'store'])->name('repuestos.store');
        Route::get('/repuestos/{repuesto}', [RepuestoController::class, 'show'])->name('repuestos.show');
        Route::get('/repuestos/{repuesto}/editar', [RepuestoController::class, 'edit'])->name('repuestos.edit');
        Route::put('/repuestos/{repuesto}', [RepuestoController::class, 'update'])->name('repuestos.update');
        Route::delete('/repuestos/{repuesto}', [RepuestoController::class, 'destroy'])->name('repuestos.destroy');

        Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.index');
        Route::get('/inventario/ingreso', [InventarioController::class, 'ingreso'])->name('inventario.ingreso');
        Route::post('/inventario/ingreso', [InventarioController::class, 'storeIngreso'])->name('inventario.store-ingreso');
        Route::get('/inventario/movimientos', [InventarioController::class, 'movimientos'])->name('inventario.movimientos');
        Route::get('/inventario/historial/{repuesto}', [InventarioController::class, 'historial'])->name('inventario.historial');

        Route::get('/categorias', [CategoriaRepuestoController::class, 'index'])->name('categorias.index');
        Route::get('/categorias/crear', [CategoriaRepuestoController::class, 'create'])->name('categorias.create');
        Route::post('/categorias', [CategoriaRepuestoController::class, 'store'])->name('categorias.store');
        Route::get('/categorias/{id}/editar', [CategoriaRepuestoController::class, 'edit'])->name('categorias.edit');
        Route::put('/categorias/{id}', [CategoriaRepuestoController::class, 'update'])->name('categorias.update');
        Route::delete('/categorias/{id}', [CategoriaRepuestoController::class, 'destroy'])->name('categorias.destroy');

        Route::get('/proveedores', [ProveedorController::class, 'index'])->name('proveedores.index');
        Route::get('/proveedores/crear', [ProveedorController::class, 'create'])->name('proveedores.create');
        Route::post('/proveedores', [ProveedorController::class, 'store'])->name('proveedores.store');
        Route::get('/proveedores/{id}/editar', [ProveedorController::class, 'edit'])->name('proveedores.edit');
        Route::put('/proveedores/{id}', [ProveedorController::class, 'update'])->name('proveedores.update');
        Route::delete('/proveedores/{id}', [ProveedorController::class, 'destroy'])->name('proveedores.destroy');

        Route::get('/especialidades', [EspecialidadController::class, 'index'])->name('especialidades.index');
        Route::get('/especialidades/crear', [EspecialidadController::class, 'create'])->name('especialidades.create');
        Route::post('/especialidades', [EspecialidadController::class, 'store'])->name('especialidades.store');
        Route::get('/especialidades/{id}/editar', [EspecialidadController::class, 'edit'])->name('especialidades.edit');
        Route::put('/especialidades/{id}', [EspecialidadController::class, 'update'])->name('especialidades.update');
        Route::delete('/especialidades/{id}', [EspecialidadController::class, 'destroy'])->name('especialidades.destroy');

        Route::get('/mecanicos', [MecanicoController::class, 'index'])->name('mecanicos.index');
        Route::get('/mecanicos/crear', [MecanicoController::class, 'create'])->name('mecanicos.create');
        Route::post('/mecanicos', [MecanicoController::class, 'store'])->name('mecanicos.store');
        Route::get('/mecanicos/{id}', [MecanicoController::class, 'show'])->name('mecanicos.show');
        Route::get('/mecanicos/{id}/editar', [MecanicoController::class, 'edit'])->name('mecanicos.edit');
        Route::put('/mecanicos/{id}', [MecanicoController::class, 'update'])->name('mecanicos.update');
        Route::delete('/mecanicos/{id}', [MecanicoController::class, 'destroy'])->name('mecanicos.destroy');

        Route::get('/sucursales', [SucursalController::class, 'index'])->name('sucursales.index');
        Route::get('/sucursales/crear', [SucursalController::class, 'create'])->name('sucursales.create');
        Route::post('/sucursales', [SucursalController::class, 'store'])->name('sucursales.store');
        Route::get('/sucursales/{sucursal}/editar', [SucursalController::class, 'edit'])->name('sucursales.edit');
        Route::put('/sucursales/{sucursal}', [SucursalController::class, 'update'])->name('sucursales.update');
        Route::delete('/sucursales/{sucursal}', [SucursalController::class, 'destroy'])->name('sucursales.destroy');

    });
});
