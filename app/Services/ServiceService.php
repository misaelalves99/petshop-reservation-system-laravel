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
            $servicosExemplo = [
                ['id' => 1, 'name' => 'Banho', 'price' => 50.00, 'duration' => 30],
                ['id' => 2, 'name' => 'Tosa', 'price' => 80.00, 'duration' => 60],
                ['id' => 3, 'name' => 'Corte de Unhas', 'price' => 20.00, 'duration' => 15],
                ['id' => 4, 'name' => 'Higienização de Ouvidos', 'price' => 15.00, 'duration' => 20],
                ['id' => 5, 'name' => 'Escovação de Dentes', 'price' => 25.00, 'duration' => 25],
                ['id' => 6, 'name' => 'Passeio', 'price' => 30.00, 'duration' => 40],
                ['id' => 7, 'name' => 'Consulta Veterinária', 'price' => 100.00, 'duration' => 60],
            ];
            session(['services' => $servicosExemplo]);
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
        $filtrados = array_filter($services, fn($s) => $s['id'] !== $id);
        session(['services' => array_values($filtrados)]);
        return count($services) !== count($filtrados);
    }
}
