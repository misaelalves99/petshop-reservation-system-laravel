<?php
// petshop-reservation-system/app/Services/PetService.php

namespace App\Services;

class PetService
{
    /**
     * Inicializa pets de exemplo em memória, se ainda não existirem
     */
    public static function seed(): void
    {
        if (!session()->has('pets')) {
            $examplePets = [
                ['id' => 1, 'name' => 'Rex', 'species' => 'Cachorro', 'age' => 3],
                ['id' => 2, 'name' => 'Mia', 'species' => 'Gato', 'age' => 2],
                ['id' => 3, 'name' => 'Coelho', 'species' => 'Coelho', 'age' => 1],
            ];
            session(['pets' => $examplePets]);
        }
    }

    /**
     * Retorna todos os pets
     */
    public static function getAll(): array
    {
        self::seed();
        return session('pets', []);
    }

    /**
     * Retorna um pet por ID
     */
    public static function find(int $id): ?array
    {
        return collect(self::getAll())->firstWhere('id', $id);
    }

    /**
     * Cria um novo pet em memória
     */
    public static function create(array $data): array
    {
        $pets = self::getAll();
        $data['id'] = count($pets) ? max(array_column($pets, 'id')) + 1 : 1;
        $pets[] = $data;
        session(['pets' => $pets]);
        return $data;
    }

    /**
     * Atualiza um pet existente em memória
     */
    public static function update(int $id, array $data): ?array
    {
        $pets = self::getAll();
        foreach ($pets as &$pet) {
            if ($pet['id'] === $id) {
                $pet = array_merge($pet, $data);
                session(['pets' => $pets]);
                return $pet;
            }
        }
        return null;
    }

    /**
     * Deleta um pet pelo ID
     */
    public static function delete(int $id): bool
    {
        $pets = self::getAll();
        $filtered = array_filter($pets, fn($p) => $p['id'] !== $id);
        session(['pets' => array_values($filtered)]);
        return count($pets) !== count($filtered);
    }
}
