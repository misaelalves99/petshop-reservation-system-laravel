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

// Reservations
Route::get('reservation', [ReservationController::class, 'index'])->name('reservations.index');
Route::get('reservation/create', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('reservation', [ReservationController::class, 'store'])->name('reservations.store');
// Dashboard/Report em memória
Route::get('reservation/report', [ReservationController::class, 'dashboard'])->name('reservation.report');
