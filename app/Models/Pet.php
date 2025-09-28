<?php
// petshop-reservation-system/app/Models/Pet.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'species', 'age'];

    // Relacionamento: Um pet pode ter várias reservas
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
