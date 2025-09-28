<?php
// petshop-reservation-system/app/Models/Service.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',      // Ex: Banho, Tosa, Vacina
        'price',     // Valor do serviço
        'duration',  // Duração em minutos
    ];

    // Relacionamento: um serviço pode ter várias reservas
    public function reservations()
    {
        return $this->hasMany(\App\Models\Reservation::class);
    }
}
