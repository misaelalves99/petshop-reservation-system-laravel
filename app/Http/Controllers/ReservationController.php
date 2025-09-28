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
            'service_type' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'status' => 'nullable|string',
        ]);

        $reservations = session('reservations', []);
        $validated['id'] = count($reservations) ? max(array_column($reservations, 'id')) + 1 : 1;
        $validated['status'] = $validated['status'] ?? 'pendente';
        $reservations[] = $validated;

        session(['reservations' => $reservations]);

        return redirect()->route('reservations.index')->with('success', 'Reserva criada com sucesso.');
    }

    /**
     * Formulário de edição de reserva
     */
    public function edit($id)
    {
        $reservations = session('reservations', []);
        $reservation = collect($reservations)->firstWhere('id', $id);

        if (!$reservation) abort(404, 'Reserva não encontrada');

        $pets = session('pets', []);
        $services = session('services', []);

        return view('reservation.edit', compact('reservation', 'pets', 'services'));
    }

    /**
     * Atualiza uma reserva existente
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'pet_id' => 'required',
            'service_type' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'status' => 'nullable|string',
        ]);

        $reservations = session('reservations', []);
        foreach ($reservations as &$res) {
            if ($res['id'] == $id) {
                $res = array_merge($res, $validated);
                $res['status'] = $res['status'] ?? 'pendente';
                break;
            }
        }

        session(['reservations' => $reservations]);

        return redirect()->route('reservations.index')->with('success', 'Reserva atualizada com sucesso.');
    }

    /**
     * Dashboard / relatório simples
     */
    public function dashboard()
    {
        $reservations = session('reservations', []);
        $pets = session('pets', []);

        // Anexa o pet a cada reserva
        foreach ($reservations as &$res) {
            $res['pet'] = collect($pets)->firstWhere('id', $res['pet_id']);
        }

        // Filtros de período
        if (request('start_date')) {
            $reservations = array_filter($reservations, fn($r) => $r['date'] >= request('start_date'));
        }
        if (request('end_date')) {
            $reservations = array_filter($reservations, fn($r) => $r['date'] <= request('end_date'));
        }

        // Estatísticas
        $summary = [
            'total_reservas' => count($reservations),
            'banho' => count(array_filter($reservations, fn($r) => $r['service_type'] == 'Banho')),
            'tosa' => count(array_filter($reservations, fn($r) => $r['service_type'] == 'Tosa')),
        ];

        return view('reservation.report', [
            'allReservations' => $reservations,
            'summary' => $summary,
        ]);
    }
    public function details($id)
    {
        $reservations = session('reservations', []);
        $reservation = collect($reservations)->firstWhere('id', $id);

        if (!$reservation) abort(404, 'Reserva não encontrada');

        return view('reservation.details', compact('reservation'));
    }

    public function delete($id)
    {
        // Recupera as reservas e pets da sessão (ou do banco, se usar DB)
        $reservations = session('reservations', []);
        $pets = session('pets', []);

        // Encontra a reserva pelo id
        $reservation = collect($reservations)->first(fn($r) => $r['id'] == $id);

        // Adiciona o pet à reserva, se encontrado
        if ($reservation) {
            $reservation['pet'] = collect($pets)->first(fn($p) => $p['id'] == ($reservation['pet_id'] ?? null));
        }

        // Passa a variável para a view
        return view('reservation.delete', compact('reservation'));
    }

    /**
     * Remove uma reserva
     */
    public function destroy($id)
    {
        $reservations = session('reservations', []);
        $reservations = array_filter($reservations, fn($r) => $r['id'] != $id);
        session(['reservations' => array_values($reservations)]);

        return redirect()->route('reservations.index')->with('success', 'Reserva excluída com sucesso.');
    }
}
