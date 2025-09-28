<?php
// petshop-reservation-system/routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes (fake login em memória)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Pets
Route::get('pet', [PetController::class, 'index'])->name('pet.index');
Route::get('pet/create', [PetController::class, 'create'])->name('pet.create');
Route::post('pet', [PetController::class, 'store'])->name('pet.store');
Route::get('pet/{pet}/edit', [PetController::class, 'edit'])->name('pet.edit');
Route::put('pet/{pet}', [PetController::class, 'update'])->name('pet.update');
Route::delete('pet/{pet}', [PetController::class, 'destroy'])->name('pet.destroy');

// Services
Route::get('service', [ServiceController::class, 'index'])->name('service.index');
Route::get('service/create', [ServiceController::class, 'create'])->name('service.create');
Route::post('service', [ServiceController::class, 'store'])->name('service.store');
Route::get('service/{service}/edit', [ServiceController::class, 'edit'])->name('service.edit');
Route::put('service/{service}', [ServiceController::class, 'update'])->name('service.update');
Route::delete('service/{service}', [ServiceController::class, 'destroy'])->name('service.destroy');

// Reservations (CRUD completo)
Route::prefix('reservation')->group(function () {

    // Listagem
    Route::get('/', [ReservationController::class, 'index'])->name('reservations.index');

    // Criação
    Route::get('/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/', [ReservationController::class, 'store'])->name('reservations.store');

    // Edição
    Route::get('/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('/{id}', [ReservationController::class, 'update'])->name('reservations.update');

    // Exclusão
    Route::delete('/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    // Relatório / Dashboard
    Route::get('/report', [ReservationController::class, 'dashboard'])->name('reservation.report');
});
