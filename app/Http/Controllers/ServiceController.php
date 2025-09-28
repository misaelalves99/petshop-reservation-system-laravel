<?php
// petshop-reservation-system/app/Http/Controllers/ServiceController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Lista todos os serviços
     */
    public function index()
    {
        $services = session('services', []);

        // Paginação manual (10 por página)
        $porPagina = 10;
        $paginaAtual = request()->input('page', 1);
        $total = count($services);
        $offset = ($paginaAtual - 1) * $porPagina;
        $servicosPaginados = array_slice($services, $offset, $porPagina);

        $servicosPaginados = new \Illuminate\Pagination\LengthAwarePaginator(
            $servicosPaginados,
            $total,
            $porPagina,
            $paginaAtual,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('service.index', ['services' => $servicosPaginados]);
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
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:0',
        ]);

        $services = session('services', []);
        $validated['id'] = count($services) ? max(array_column($services, 'id')) + 1 : 1;
        $services[] = $validated;

        session(['services' => $services]);

        return redirect()->route('service.index')->with('success', 'Serviço criado com sucesso.');
    }

    /**
     * Edita serviço
     */
    public function edit($id)
    {
        $services = session('services', []);
        $service = collect($services)->firstWhere('id', $id);

        if (!$service) abort(404, 'Serviço não encontrado');

        return view('service.edit', compact('service'));
    }

    /**
     * Atualiza serviço
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:0',
        ]);

        $services = session('services', []);
        foreach ($services as &$service) {
            if ($service['id'] == $id) {
                $service = array_merge($service, $validated);
                break;
            }
        }

        session(['services' => $services]);

        return redirect()->route('service.index')->with('success', 'Serviço atualizado com sucesso.');
    }

    /**
     * Remove serviço
     */
    public function destroy($id)
    {
        $services = session('services', []);
        $services = array_filter($services, fn($s) => $s['id'] != $id);
        session(['services' => array_values($services)]);

        return redirect()->route('service.index')->with('success', 'Serviço excluído com sucesso.');
    }
}
