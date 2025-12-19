<?php

use App\Http\Controllers\PersonalController;
use App\Http\Controllers\PuestoController;
use App\Http\Controllers\SucursalController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth'])->group(function () {

    Route::resource('puestos', PuestoController::class);
    Route::resource('personal', PersonalController::class);
    Route::resource('sucursales', SucursalController::class);

});

require __DIR__.'/settings.php';
