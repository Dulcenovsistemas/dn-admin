<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\SubproductController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth','module:recetario'])->group(function () {

    Route::view('/recetario', 'modules.recetario.index');

});

Route::middleware(['auth','module:produccion'])->group(function () {

    Route::view('/produccion', 'modules.produccion.index');

});

Route::middleware(['auth','module:mantenimiento'])->group(function () {

    Route::view('/mantenimiento', 'modules.mantenimiento.index');

});

Route::middleware(['auth','module:recetario'])->group(function () {

    Route::resource('ingredientes', IngredientController::class);
    Route::resource('recetas', RecipeController::class);

});

use App\Http\Controllers\UserController;

Route::middleware(['auth'])->group(function () {

    Route::resource('usuarios', UserController::class);

});

use App\Http\Controllers\SucursalController;

Route::resource('sucursales', SucursalController::class);

use App\Http\Controllers\EquipoController;

Route::resource('equipos', EquipoController::class);

Route::get('/equipos/sucursal/{id}', [EquipoController::class, 'porSucursal'])
    ->name('equipos.sucursal');

Route::get('/equipos/area/{id}', [EquipoController::class, 'porArea'])
    ->name('equipos.area');  