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

Route::get('/equipos/create/{area}', [EquipoController::class, 'create'])
    ->name('equipos.create');

Route::resource('equipos', EquipoController::class);

Route::get('/equipos/sucursal/{id}', [EquipoController::class, 'porSucursal'])
    ->name('equipos.sucursal');

Route::get('/equipos/area/{id}', [EquipoController::class, 'porArea'])
    ->name('equipos.area');  


use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\SubcategoriaController;

Route::resource('categorias', CategoriaController::class);
Route::resource('subcategorias', SubcategoriaController::class);

use App\Http\Controllers\ItemController;

Route::resource('items', ItemController::class);

Route::get('items/{item}/costs', [ItemController::class, 'costs'])->name('items.costs');
Route::post('items/{item}/costs', [ItemController::class, 'storeCosts'])->name('items.costs.store');
Route::post('items/{item}/costs', [ItemController::class, 'storeCosts'])
    ->name('items.costs.store');

use App\Http\Controllers\EmployeeController;

Route::resource('employees', EmployeeController::class);

Route::middleware(['auth', 'module:rh'])->group(function () {

    Route::view('/rh', 'modules.rh.index')
        ->name('rh.index');

});

use App\Http\Controllers\EmployeeVacationController;

Route::middleware(['auth'])->group(function () {
    Route::get('/vacations', [EmployeeVacationController::class, 'index'])->name('vacations.index');
    Route::get('/vacations/create/{employee}', [EmployeeVacationController::class, 'create'])->name('vacations.create');
    Route::post('/vacations/store', [EmployeeVacationController::class, 'store'])->name('vacations.store');
    Route::get('/vacations/{employee}/periods', [EmployeeVacationController::class, 'periods'])->name('vacations.periods');
    Route::get('/vacations/{vacation}/receipt', [EmployeeVacationController::class, 'receipt'])->name('vacations.receipt');
});

Route::get('/vacations/{vacation}/edit', [EmployeeVacationController::class, 'edit'])->name('vacations.edit');
Route::put('/vacations/{vacation}', [EmployeeVacationController::class, 'update'])->name('vacations.update');

Route::get('/vacations/{vacation}/receipt-pdf', [EmployeeVacationController::class, 'receiptPdf'])
    ->name('vacations.receipt.pdf');

Route::delete('/vacations/{vacation}', [EmployeeVacationController::class, 'destroy'])
    ->name('vacations.destroy');

use App\Http\Controllers\ServicioController;

Route::get('/servicios', [ServicioController::class, 'index'])
    ->name('servicios.index');

Route::get('/servicios/sucursal/{id}', [ServicioController::class, 'porSucursal'])
    ->name('servicios.sucursal');

Route::get('/servicios/area/{area}', [ServicioController::class, 'porArea'])
    ->name('servicios.area');

Route::get('/servicios/create/{area}', [ServicioController::class, 'create'])
    ->name('servicios.create');

Route::resource('servicios', ServicioController::class)
    ->except(['index', 'create']);
    
use App\Http\Controllers\ChecadaController;

Route::get('/checadas', [ChecadaController::class, 'index'])
    ->name('checadas.index');

Route::post('/checadas/importar', [ChecadaController::class, 'importar'])
    ->name('checadas.importar');