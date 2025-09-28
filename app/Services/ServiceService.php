<?php
// petshop-reservation-system/app/Services/ServiceService.php

namespace App\Services;

class ServiceService
{
    /**
     * Inicializa serviços de exemplo em memória, se ainda não existirem
     */
    public static function seed(): void
    {
        if (!session()->has('services')) {
            $exemploServicos = [
                ['id' => 1, 'name' => 'Banho', 'price' => 50.00, 'duration' => 30],
                ['id' => 2, 'name' => 'Tosa', 'price' => 80.00, 'duration' => 60],
                ['id' => 3, 'name' => 'Corte de Unhas', 'price' => 20.00, 'duration' => 15],
            ];
            session(['services' => $exemploServicos]);
        }
    }

    /**
     * Retorna todos os serviços
     */
    public static function getAll(): array
    {
        self::seed();
        return session('services', []);
    }

    /**
     * Retorna um serviço pelo ID
     */
    public static function find(int $id): ?array
    {
        return collect(self::getAll())->firstWhere('id', $id);
    }

    /**
     * Cria um novo serviço em memória
     */
    public static function create(array $data): array
    {
        $services = self::getAll();
        $data['id'] = count($services) ? max(array_column($services, 'id')) + 1 : 1;
        $services[] = $data;
        session(['services' => $services]);
        return $data;
    }

    /**
     * Atualiza um serviço existente em memória
     */
    public static function update(int $id, array $data): ?array
    {
        $services = self::getAll();
        foreach ($services as &$service) {
            if ($service['id'] === $id) {
                $service = array_merge($service, $data);
                session(['services' => $services]);
                return $service;
            }
        }
        return null;
    }

    /**
     * Deleta um serviço pelo ID
     */
    public static function delete(int $id): bool
    {
        $services = self::getAll();
        $filtered = array_filter($services, fn($s) => $s['id'] !== $id);
        session(['services' => array_values($filtered)]);
        return count($services) !== count($filtered);
    }
}
