<?php
// petshop-reservation-system/app/Http/Controllers/PetController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetController extends Controller
{
    /**
     * Lista todos os pets com filtro por nome e paginação.
     * Se estiver usando in-memory, substitua Pet::withCount() por array_count_values()
     */
    public function index(Request $request)
    {
        // Exemplo em memória (substitui Pet::withCount('reservations') se não houver DB)
        $pets = session('pets', []);

        // Filtro por nome
        if ($request->filled('search')) {
            $pets = array_filter($pets, fn($pet) => str_contains(strtolower($pet['name']), strtolower($request->search)));
        }

        // Paginação manual (10 por página)
        $perPage = 10;
        $currentPage = $request->input('page', 1);
        $total = count($pets);
        $offset = ($currentPage - 1) * $perPage;
        $pagedPets = array_slice($pets, $offset, $perPage);

        // Cria um objeto tipo LengthAwarePaginator para compatibilidade com Blade
        $pagedPets = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedPets,
            $total,
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('pet.index', ['pets' => $pagedPets]);
    }

    /**
     * Exibe o formulário de criação de pet
     */
    public function create()
    {
        return view('pet.create');
    }

    /**
     * Salva um pet novo (em memória)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'age' => 'nullable|integer|min:0',
        ]);

        $pets = session('pets', []);
        $data['id'] = count($pets) ? max(array_column($pets, 'id')) + 1 : 1;
        $data['reservations'] = [];
        $pets[] = $data;

        session(['pets' => $pets]);

        return redirect()->route('pet.index')->with('success', 'Pet created successfully.');
    }

    /**
     * Exibe o formulário de edição
     */
    public function edit($id)
    {
        $pets = session('pets', []);
        $pet = collect($pets)->firstWhere('id', $id);

        if (!$pet) {
            abort(404, 'Pet not found.');
        }

        return view('pet.edit', ['pet' => $pet]);
    }

    /**
     * Atualiza um pet em memória
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'age' => 'nullable|integer|min:0',
        ]);

        $pets = session('pets', []);
        foreach ($pets as &$pet) {
            if ($pet['id'] == $id) {
                $pet = array_merge($pet, $data);
                break;
            }
        }

        session(['pets' => $pets]);

        return redirect()->route('pet.index')->with('success', 'Pet updated successfully.');
    }

    /**
     * Remove um pet
     */
    public function destroy($id)
    {
        $pets = session('pets', []);
        $pets = array_filter($pets, fn($pet) => $pet['id'] != $id);
        session(['pets' => array_values($pets)]);

        return redirect()->route('pet.index')->with('success', 'Pet deleted successfully.');
    }
}
