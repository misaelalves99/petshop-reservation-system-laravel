<?php
// petshop-reservation-system/app/Services/PetService.php

namespace App\Services;

class PetService
{
    /**
     * Inicializa pets de exemplo em memória, se ainda não existirem
     */
    public static function inicializar(): void
    {
        if (!session()->has('pets')) {
            $petsExemplo = [
                ['id' => 1, 'name' => 'Rex', 'species' => 'Cachorro', 'age' => 3],
                ['id' => 2, 'name' => 'Mia', 'species' => 'Gato', 'age' => 2],
                ['id' => 3, 'name' => 'Coelho', 'species' => 'Coelho', 'age' => 1],
            ];
            session(['pets' => $petsExemplo]);
        }
    }

    /**
     * Retorna todos os pets
     */
    public static function todos(): array
    {
        self::inicializar();
        return session('pets', []);
    }

    /**
     * Retorna um pet pelo ID
     */
    public static function buscar(int $id): ?array
    {
        return collect(self::todos())->firstWhere('id', $id);
    }

    /**
     * Cria um novo pet
     */
    public static function criar(array $dados): array
    {
        $pets = self::todos();

        // Garante próximo ID
        $novoId = count($pets) ? max(array_column($pets, 'id')) + 1 : 1;
        $dados['id'] = $novoId;

        // Garante que age esteja presente
        if (!isset($dados['age'])) {
            $dados['age'] = null;
        }

        $pets[] = $dados;
        session(['pets' => $pets]);

        return $dados;
    }

    /**
     * Atualiza um pet existente
     */
    public static function atualizar(int $id, array $dados): ?array
    {
        $pets = self::todos();

        foreach ($pets as &$pet) {
            if ($pet['id'] === $id) {
                // Mantém campos existentes e sobrescreve com novos
                $pet = array_merge($pet, $dados);

                // Garante que age exista
                if (!isset($pet['age'])) {
                    $pet['age'] = null;
                }

                session(['pets' => $pets]);
                return $pet;
            }
        }

        return null;
    }

    /**
     * Deleta um pet pelo ID
     */
    public static function deletar(int $id): bool
    {
        $pets = self::todos();
        $filtrados = array_filter($pets, fn($p) => $p['id'] !== $id);
        session(['pets' => array_values($filtrados)]);
        return count($pets) !== count($filtrados);
    }
}
