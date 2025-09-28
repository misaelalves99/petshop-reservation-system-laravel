<?php
// petshop-reservation-system/app/Http/Controllers/ServiceController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\ServiceService;

class ServiceController extends Controller
{
    /**
     * Lista todos os serviços
     */
    public function index(Request $request)
    {
        $services = ServiceService::getAll();

        // Paginação manual (10 por página)
        $perPage = 10;
        $currentPage = $request->input('page', 1);
        $total = count($services);
        $offset = ($currentPage - 1) * $perPage;
        $pagedServices = array_slice($services, $offset, $perPage);

        $pagedServices = new LengthAwarePaginator(
            $pagedServices,
            $total,
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('service.index', ['services' => $pagedServices]);
    }

    /**
     * Formulário para criar serviço
     */
    public function create()
    {
        return view('service.create');
    }

    /**
     * Salva novo serviço
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
            'duration' => 'required|integer|min:0',
        ]);

        ServiceService::create($validated);

        return redirect()->route('service.index')->with('success', 'Serviço criado com sucesso.');
    }

    /**
     * Edita serviço
     */
    public function edit($id)
    {
        $service = ServiceService::find($id);

        if (!$service) {
            abort(404, 'Serviço não encontrado.');
        }

        return view('service.edit', compact('service'));
    }

    /**
     * Atualiza serviço
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
            'duration' => 'required|integer|min:0',
        ]);

        ServiceService::update($id, $validated);

        return redirect()->route('service.index')->with('success', 'Serviço atualizado com sucesso.');
    }

    /**
     * Remove serviço
     */
    public function destroy($id)
    {
        ServiceService::delete($id);

        return redirect()->route('service.index')->with('success', 'Serviço deletado com sucesso.');
    }
}
