<?php
// petshop-reservation-system/routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Autenticação fake
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Pets
Route::prefix('pet')->group(function () {
    Route::get('/', [PetController::class, 'index'])->name('pet.index');
    Route::get('/create', [PetController::class, 'create'])->name('pet.create');
    Route::post('/', [PetController::class, 'store'])->name('pet.store');
    Route::get('/{pet}/edit', [PetController::class, 'edit'])->name('pet.edit');
    Route::put('/{pet}', [PetController::class, 'update'])->name('pet.update');
    Route::delete('/{pet}', [PetController::class, 'destroy'])->name('pet.destroy');
    Route::get('/{pet}/details', [PetController::class, 'details'])->name('pet.details');
    Route::get('/{pet}/delete', [PetController::class, 'delete'])->name('pet.delete');
});

// Serviços
Route::prefix('service')->group(function () {
    Route::get('/', [ServiceController::class, 'index'])->name('service.index');
    Route::get('/create', [ServiceController::class, 'create'])->name('service.create');
    Route::post('/', [ServiceController::class, 'store'])->name('service.store');
    Route::get('/{service}/edit', [ServiceController::class, 'edit'])->name('service.edit');
    Route::put('/{service}', [ServiceController::class, 'update'])->name('service.update');
    Route::delete('/{service}', [ServiceController::class, 'destroy'])->name('service.destroy');
    Route::get('/{service}/delete', [ServiceController::class, 'delete'])->name('service.delete');
    Route::get('/{service}/details', [ServiceController::class, 'details'])->name('service.details');
});

// Reservas
Route::prefix('reservation')->group(function () {
    Route::get('/', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('/{id}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    Route::get('/{id}/delete', [ReservationController::class, 'delete'])->name('reservations.delete');
    Route::get('/{id}/details', [ReservationController::class, 'details'])->name('reservations.details');
    Route::get('/report', [ReservationController::class, 'dashboard'])->name('reservation.report');
});
