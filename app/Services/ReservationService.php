<?php

namespace App\Services;

use App\Models\Reservation;
use Carbon\Carbon;

class ReservationService
{
    public function createReservation(array $data): Reservation
    {
        // Aqui você pode adicionar regras extras, ex: checar horário disponível
        return Reservation::create($data);
    }

    public function getUpcomingReservations()
    {
        return Reservation::with('pet')
            ->whereDate('date', '>=', Carbon::today())
            ->orderBy('date')
            ->get();
    }

    public function getReport()
    {
        return Reservation::with('pet')
            ->orderBy('date', 'desc')
            ->get();
    }
}
