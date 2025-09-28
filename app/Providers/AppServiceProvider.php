<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Inicializar pets de exemplo
        if (!session()->has('pets')) {
            session(['pets' => [
                ['id' => 1, 'name' => 'Buddy', 'species' => 'Dog', 'age' => 3],
                ['id' => 2, 'name' => 'Mittens', 'species' => 'Cat', 'age' => 2],
                ['id' => 3, 'name' => 'Charlie', 'species' => 'Rabbit', 'age' => 1],
            ]]);
        }

        // Inicializar serviços de exemplo
        if (!session()->has('services')) {
            session(['services' => [
                ['id' => 1, 'name' => 'Bath', 'price' => 25.00, 'duration' => 30],
                ['id' => 2, 'name' => 'Grooming', 'price' => 50.00, 'duration' => 60],
            ]]);
        }

        // Inicializar reservas de exemplo
        if (!session()->has('reservations')) {
            session(['reservations' => [
                ['id' => 1, 'pet_id' => 1, 'service_id' => 1, 'service_type' => 'Bath', 'date' => '2025-10-01', 'time' => '10:00', 'status' => 'pending'],
                ['id' => 2, 'pet_id' => 2, 'service_id' => 2, 'service_type' => 'Grooming', 'date' => '2025-10-02', 'time' => '14:00', 'status' => 'completed'],
                ['id' => 3, 'pet_id' => 3, 'service_id' => 1, 'service_type' => 'Bath', 'date' => '2025-10-03', 'time' => '09:30', 'status' => 'pending'],
            ]]);
        }
    }
}
