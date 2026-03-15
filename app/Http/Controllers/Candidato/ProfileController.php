<?php

namespace App\Http\Controllers\Candidato;

use App\Http\Controllers\Controller;
use App\Models\CategoriaLaboral;
use App\Models\Departamento;
use App\Models\Habilidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $profile = auth()->user()->candidatoProfile;

        if (! $profile) {
            return redirect()->route('candidato.perfil.create');
        }

        $profile->load(['departamento', 'categoriaLaboral', 'habilidades', 'experiencias']);

        return view('candidato.profile.show', compact('profile'));
    }

    public function create()
    {
        if (auth()->user()->candidatoProfile) {
            return redirect()->route('candidato.perfil.show');
        }

        $departamentos = Departamento::orderBy('nombre')->get();
        $categorias = CategoriaLaboral::orderBy('nombre')->get();
        $habilidades = Habilidad::orderBy('nombre')->get();

        return view('candidato.profile.create', compact('departamentos', 'categorias', 'habilidades'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'departamento_id' => 'required|exists:departamentos,id',
            'categoria_laboral_id' => 'required|exists:categorias_laborales,id',
            'modalidad_trabajo' => 'required|in:presencial,remoto,hibrido',
            'nivel_educativo' => 'nullable|string|max:100',
            'sobre_mi' => 'nullable|string|max:1000',
            'tipo_discapacidad' => 'nullable|string|max:100',
            'tiene_certificado' => 'nullable|boolean',
            'necesidades_adaptacion' => 'nullable|string|max:1000',
            'visibilidad_discapacidad' => 'required|in:publica,bajo_solicitud,privada',
            'habilidades' => 'nullable|array',
            'habilidades.*' => 'exists:habilidades,id',
            'certificado' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $habilidades = $validated['habilidades'] ?? [];
        unset($validated['habilidades']);

        if ($request->hasFile('certificado')) {
            $validated['certificado_path'] = $request->file('certificado')->store('certificados', 'local');
            $validated['certificado_estado'] = 'pendiente';
        }
        unset($validated['certificado']);

        $profile = auth()->user()->candidatoProfile()->create($validated);
        $profile->habilidades()->sync($habilidades);

        return redirect()->route('candidato.perfil.show')->with('success', 'Perfil creado correctamente.');
    }

    public function edit()
    {
        $profile = auth()->user()->candidatoProfile;

        if (! $profile) {
            return redirect()->route('candidato.perfil.create');
        }

        $departamentos = Departamento::orderBy('nombre')->get();
        $categorias = CategoriaLaboral::orderBy('nombre')->get();
        $habilidades = Habilidad::orderBy('nombre')->get();

        return view('candidato.profile.edit', compact('profile', 'departamentos', 'categorias', 'habilidades'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'departamento_id' => 'required|exists:departamentos,id',
            'categoria_laboral_id' => 'required|exists:categorias_laborales,id',
            'modalidad_trabajo' => 'required|in:presencial,remoto,hibrido',
            'nivel_educativo' => 'nullable|string|max:100',
            'sobre_mi' => 'nullable|string|max:1000',
            'tipo_discapacidad' => 'nullable|string|max:100',
            'tiene_certificado' => 'nullable|boolean',
            'necesidades_adaptacion' => 'nullable|string|max:1000',
            'visibilidad_discapacidad' => 'required|in:publica,bajo_solicitud,privada',
            'habilidades' => 'nullable|array',
            'habilidades.*' => 'exists:habilidades,id',
            'certificado' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $habilidades = $validated['habilidades'] ?? [];
        unset($validated['habilidades']);

        $profile = auth()->user()->candidatoProfile;

        if ($request->hasFile('certificado')) {
            if ($profile->certificado_path) {
                Storage::disk('local')->delete($profile->certificado_path);
            }
            $validated['certificado_path'] = $request->file('certificado')->store('certificados', 'local');
            $validated['certificado_estado'] = 'pendiente';
        }
        unset($validated['certificado']);

        $profile->update($validated);
        $profile->habilidades()->sync($habilidades);

        return redirect()->route('candidato.perfil.show')->with('success', 'Perfil actualizado correctamente.');
    }
}
