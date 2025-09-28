<?php
// petshop-reservation-system/app/Http/Controllers/ReservationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Lista todas as reservas
     */
    public function index()
    {
        $reservations = session('reservations', []);
        $pets = session('pets', []);

        // Anexa o pet a cada reserva
        foreach ($reservations as &$res) {
            $res['pet'] = collect($pets)->firstWhere('id', $res['pet_id']);
        }

        return view('reservation.index', ['reservations' => $reservations]);
    }

    /**
     * Formulário de criação de reserva
     */
    public function create()
    {
        $pets = session('pets', []);
        $services = session('services', []);

        return view('reservation.create', compact('pets', 'services'));
    }

    /**
     * Salva nova reserva em memória
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pet_id' => 'required',
            'service_id' => 'required',
            'date' => 'required|date',
            'time' => 'required'
        ]);

        $reservations = session('reservations', []);
        $validated['id'] = count($reservations) ? max(array_column($reservations, 'id')) + 1 : 1;
        $reservations[] = $validated;

        session(['reservations' => $reservations]);

        return redirect()->route('reservation.index')->with('success', 'Reservation created successfully.');
    }

    /**
     * Dashboard simples (estatísticas)
     */
    public function dashboard()
    {
        $reservations = session('reservations', []);
        $stats = [
            'total_reservations' => count($reservations),
            'reservations_today' => count(array_filter($reservations, fn($r) => $r['date'] === date('Y-m-d'))),
        ];

        return view('reservation.dashboard', compact('stats'));
    }
}
