<?php
// app/Repositories/InMemoryPetRepository.php

namespace App\Repositories;

use App\Models\Pet;

class InMemoryPetRepository
{
    private static array $pets = [];
    private static int $nextId = 1;

    public function all()
    {
        return array_values(self::$pets);
    }

    public function find(int $id)
    {
        return self::$pets[$id] ?? null;
    }

    public function create(array $data)
    {
        $data['id'] = self::$nextId++;
        self::$pets[$data['id']] = (object) $data;
        return self::$pets[$data['id']];
    }

    public function update(int $id, array $data)
    {
        if (!isset(self::$pets[$id])) return null;
        self::$pets[$id] = (object) array_merge((array)self::$pets[$id], $data);
        return self::$pets[$id];
    }

    public function delete(int $id)
    {
        if (isset(self::$pets[$id])) {
            unset(self::$pets[$id]);
            return true;
        }
        return false;
    }
}
