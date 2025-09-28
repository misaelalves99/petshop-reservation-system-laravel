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
        return session('pets', []);
    }

    /**
     * Retorna todos os serviços disponíveis em memória
     */
    public static function getServices(): array
    {
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
            $res['pet'] = collect($pets)->firstWhere('id', $res['pet_id']) ?? ['id' => null, 'name' => '-', 'species' => '-', 'age' => null];
            $res['service'] = collect($services)->firstWhere('id', $res['service_id']) ?? ['id' => null, 'name' => '-', 'price' => 0, 'duration' => 0];
        }

        return $reservations;
    }

    /**
     * Cria uma nova reserva em memória
     */
    public static function createReservation(array $data): array
    {
        $reservations = session('reservations', []);

        // Garante próximo ID
        $data['id'] = count($reservations) ? max(array_column($reservations, 'id')) + 1 : 1;

        // Garante status padrão
        if (!isset($data['status'])) {
            $data['status'] = 'pendente';
        }

        $reservations[] = $data;
        session(['reservations' => $reservations]);

        return $data;
    }

    /**
     * Atualiza uma reserva existente
     */
    public static function updateReservation(int $id, array $data): ?array
    {
        $reservations = session('reservations', []);

        foreach ($reservations as &$res) {
            if ($res['id'] === $id) {
                $res = array_merge($res, $data);
                if (!isset($res['status'])) {
                    $res['status'] = 'pendente';
                }
                session(['reservations' => $reservations]);
                return $res;
            }
        }

        return null;
    }

    /**
     * Deleta uma reserva pelo ID
     */
    public static function deleteReservation(int $id): bool
    {
        $reservations = session('reservations', []);
        $filtradas = array_filter($reservations, fn($r) => $r['id'] != $id);
        session(['reservations' => array_values($filtradas)]);
        return count($reservations) !== count($filtradas);
    }

    /**
     * Retorna uma reserva pelo ID
     */
    public static function findReservation(int $id): ?array
    {
        return collect(self::getReservations())->firstWhere('id', $id);
    }
}
