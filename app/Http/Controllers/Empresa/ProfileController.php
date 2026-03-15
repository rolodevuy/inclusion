<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Departamento;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        $profile = auth()->user()->empresaProfile;

        if (! $profile) {
            return redirect()->route('empresa.perfil.create');
        }

        $profile->load('departamento');

        return view('empresa.profile.show', compact('profile'));
    }

    public function create()
    {
        if (auth()->user()->empresaProfile) {
            return redirect()->route('empresa.perfil.show');
        }

        $departamentos = Departamento::orderBy('nombre')->get();

        return view('empresa.profile.create', compact('departamentos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rut' => 'required|string|max:20',
            'sector' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:2000',
            'departamento_id' => 'required|exists:departamentos,id',
            'sitio_web' => 'nullable|url|max:255',
            'politicas_inclusion' => 'nullable|string|max:2000',
        ]);

        auth()->user()->empresaProfile()->create($validated);

        return redirect()->route('empresa.perfil.show')->with('success', 'Perfil de empresa creado correctamente.');
    }

    public function edit()
    {
        $profile = auth()->user()->empresaProfile;

        if (! $profile) {
            return redirect()->route('empresa.perfil.create');
        }

        $departamentos = Departamento::orderBy('nombre')->get();

        return view('empresa.profile.edit', compact('profile', 'departamentos'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'rut' => 'required|string|max:20',
            'sector' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:2000',
            'departamento_id' => 'required|exists:departamentos,id',
            'sitio_web' => 'nullable|url|max:255',
            'politicas_inclusion' => 'nullable|string|max:2000',
        ]);

        auth()->user()->empresaProfile->update($validated);

        return redirect()->route('empresa.perfil.show')->with('success', 'Perfil actualizado correctamente.');
    }
}
