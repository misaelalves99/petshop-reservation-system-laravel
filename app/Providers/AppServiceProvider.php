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
                ['id' => 1, 'name' => 'Buddy', 'species' => 'Cachorro', 'age' => 3],
                ['id' => 2, 'name' => 'Mittens', 'species' => 'Gato', 'age' => 2],
                ['id' => 3, 'name' => 'Charlie', 'species' => 'Coelho', 'age' => 1],
            ]]);
        }

        // Inicializar serviços de exemplo
        if (!session()->has('services')) {
            session(['services' => [
                ['id' => 1, 'name' => 'Banho', 'price' => 25.00, 'duration' => 30],
                ['id' => 2, 'name' => 'Tosa', 'price' => 50.00, 'duration' => 60],
                ['id' => 3, 'name' => 'Corte de Unhas', 'price' => 15.00, 'duration' => 15],
                ['id' => 4, 'name' => 'Escovação', 'price' => 20.00, 'duration' => 20],
                ['id' => 5, 'name' => 'Hidratação', 'price' => 35.00, 'duration' => 40],
                ['id' => 6, 'name' => 'Limpeza de Ouvidos', 'price' => 10.00, 'duration' => 10],
                ['id' => 7, 'name' => 'Banho e Tosa Completo', 'price' => 70.00, 'duration' => 90],
                ['id' => 8, 'name' => 'Tosa Higiênica', 'price' => 30.00, 'duration' => 25],
                ['id' => 9, 'name' => 'Tratamento Antipulgas', 'price' => 40.00, 'duration' => 45],
            ]]);
        }

        // Inicializar reservas de exemplo
        if (!session()->has('reservations')) {
            session(['reservations' => [
                [
                    'id' => 1,
                    'pet_id' => 1,
                    'service_id' => 1,
                    'service_type' => 'Banho',
                    'date' => '2025-10-01',
                    'time' => '10:00',
                    'status' => 'pendente'
                ],
                [
                    'id' => 2,
                    'pet_id' => 2,
                    'service_id' => 2,
                    'service_type' => 'Tosa',
                    'date' => '2025-10-02',
                    'time' => '14:00',
                    'status' => 'concluída'
                ],
                [
                    'id' => 3,
                    'pet_id' => 3,
                    'service_id' => 1,
                    'service_type' => 'Banho',
                    'date' => '2025-10-03',
                    'time' => '09:30',
                    'status' => 'pendente'
                ],
            ]]);
        }
    }
}
