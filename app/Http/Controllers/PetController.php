<?php
// petshop-reservation-system/app/Http/Controllers/PetController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\PetService;
use App\Services\ServiceService;

class PetController extends Controller
{
    /**
     * Lista todos os pets com filtro por nome e paginação
     */
    public function index(Request $request)
    {
        $pets = PetService::todos();

        // Filtro por nome (search)
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $pets = array_filter($pets, fn($pet) => str_contains(strtolower($pet['name']), $search));
        }

        // Paginação manual (10 por página)
        $perPage = 10;
        $currentPage = $request->input('page', 1);
        $total = count($pets);
        $offset = ($currentPage - 1) * $perPage;
        $pagedPets = array_slice($pets, $offset, $perPage);

        $pagedPets = new LengthAwarePaginator(
            $pagedPets,
            $total,
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
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
            'name'    => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'age'     => 'nullable|integer|min:0',
        ]);

        PetService::criar($data);

        return redirect()->route('pet.index')->with('success', 'Pet criado com sucesso.');
    }

    /**
     * Exibe o formulário de edição de pet
     */
    public function edit($id)
    {
        $pet = PetService::buscar($id);
        if (!$pet) {
            abort(404, 'Pet não encontrado');
        }

        $services = ServiceService::getAll(); // Para exibir nomes de serviços nas reservas
        return view('pet.edit', compact('pet', 'services'));
    }

    /**
     * Atualiza um pet em memória
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'age'     => 'nullable|integer|min:0',
        ]);

        PetService::atualizar($id, $data);

        return redirect()->route('pet.index')->with('success', 'Pet atualizado com sucesso.');
    }

    /**
     * Remove um pet
     */
    public function destroy($id)
    {
        PetService::deletar($id);
        return redirect()->route('pet.index')->with('success', 'Pet deletado com sucesso.');
    }
}
