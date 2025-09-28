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
                ['id' => 1, 'nome' => 'Rex', 'especie' => 'Cachorro', 'idade' => 3],
                ['id' => 2, 'nome' => 'Mia', 'especie' => 'Gato', 'idade' => 2],
                ['id' => 3, 'nome' => 'Coelho', 'especie' => 'Coelho', 'idade' => 1],
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
     * Cria um novo pet em memória
     */
    public static function criar(array $dados): array
    {
        $pets = self::todos();
        $dados['id'] = count($pets) ? max(array_column($pets, 'id')) + 1 : 1;
        $pets[] = $dados;
        session(['pets' => $pets]);
        return $dados;
    }

    /**
     * Atualiza um pet existente em memória
     */
    public static function atualizar(int $id, array $dados): ?array
    {
        $pets = self::todos();
        foreach ($pets as &$pet) {
            if ($pet['id'] === $id) {
                $pet = array_merge($pet, $dados);
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
