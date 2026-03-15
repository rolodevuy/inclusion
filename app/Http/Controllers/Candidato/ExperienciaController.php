<?php

namespace App\Http\Controllers\Candidato;

use App\Http\Controllers\Controller;
use App\Models\CandidatoExperiencia;
use Illuminate\Http\Request;

class ExperienciaController extends Controller
{
    public function create()
    {
        return view('candidato.experiencias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cargo' => 'required|string|max:255',
            'empresa' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        $profile = auth()->user()->candidatoProfile;

        if (! $profile) {
            return redirect()->route('candidato.perfil.create');
        }

        $profile->experiencias()->create($validated);

        return redirect()->route('candidato.perfil.show')->with('success', 'Experiencia agregada correctamente.');
    }

    public function edit(CandidatoExperiencia $experiencia)
    {
        if ($experiencia->profile->user_id !== auth()->id()) {
            abort(403);
        }

        return view('candidato.experiencias.edit', compact('experiencia'));
    }

    public function update(Request $request, CandidatoExperiencia $experiencia)
    {
        if ($experiencia->profile->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'cargo' => 'required|string|max:255',
            'empresa' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        $experiencia->update($validated);

        return redirect()->route('candidato.perfil.show')->with('success', 'Experiencia actualizada correctamente.');
    }

    public function destroy(CandidatoExperiencia $experiencia)
    {
        if ($experiencia->profile->user_id !== auth()->id()) {
            abort(403);
        }

        $experiencia->delete();

        return redirect()->route('candidato.perfil.show')->with('success', 'Experiencia eliminada correctamente.');
    }
}
