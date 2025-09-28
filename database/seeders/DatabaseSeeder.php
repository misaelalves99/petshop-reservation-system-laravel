<?php
// petshop-reservation-system/database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pet;
use App\Models\Service;
use App\Models\Reservation;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuários
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@petshop.com',
            'password' => bcrypt('password'),
        ]);

        // Pets
        Pet::factory()->createMany([
            ['name' => 'Rex', 'species' => 'Dog', 'age' => 3],
            ['name' => 'Mittens', 'species' => 'Cat', 'age' => 2],
        ]);

        // Serviços
        Service::create(['name' => 'Bath', 'price' => 30.00]);
        Service::create(['name' => 'Haircut', 'price' => 50.00]);

        // Reservas (Exemplo)
        Reservation::create([
            'pet_id' => 1,
            'service_id' => 1,
            'date' => now()->addDay(),
        ]);
    }
}
