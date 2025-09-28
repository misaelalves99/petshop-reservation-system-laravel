<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'service_id',
        'date',
        'time',
        'status' // pending, confirmed, completed, cancelled
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function scopeUpcoming($query)
    {
        return $query->whereDate('date', '>=', now())->orderBy('date');
    }
}
