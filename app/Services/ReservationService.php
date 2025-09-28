<?php
// petshop-reservation-system/app/Services/ReservationService.php

namespace App\Services;

class ReservationService
{
    /**
     * Retorna todos os pets disponíveis em memória
     */
    public static function getPets(): array
    {
        // Garante que os pets de exemplo existam
        \App\Services\PetService::seed();
        return session('pets', []);
    }

    /**
     * Retorna todos os serviços disponíveis em memória
     */
    public static function getServices(): array
    {
        // Garante que os serviços de exemplo existam
        \App\Services\ServiceService::seed();
        return session('services', []);
    }

    /**
     * Retorna todas as reservas com dados do pet e serviço anexados
     */
    public static function getReservations(): array
    {
        $reservations = session('reservations', []);
        $pets = self::getPets();
        $services = self::getServices();

        foreach ($reservations as &$res) {
            $res['pet'] = collect($pets)->firstWhere('id', $res['pet_id']) ?? null;
            $res['service'] = collect($services)->firstWhere('id', $res['service_id']) ?? null;
        }

        return $reservations;
    }

    /**
     * Cria uma nova reserva em memória
     */
    public static function createReservation(array $data): void
    {
        $reservations = session('reservations', []);
        $data['id'] = count($reservations) ? max(array_column($reservations, 'id')) + 1 : 1;
        // Status padrão
        $data['status'] = $data['status'] ?? 'pendente';
        $reservations[] = $data;
        session(['reservations' => $reservations]);
    }

    /**
     * Deleta uma reserva pelo ID
     */
    public static function deleteReservation(int $id): void
    {
        $reservations = session('reservations', []);
        $reservations = array_filter($reservations, fn($r) => $r['id'] != $id);
        session(['reservations' => array_values($reservations)]);
    }
}
