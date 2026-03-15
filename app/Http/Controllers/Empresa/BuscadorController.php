<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\CandidatoProfile;
use App\Models\CategoriaLaboral;
use App\Models\Departamento;
use App\Models\Habilidad;
use App\Models\SolicitudAcceso;
use Illuminate\Http\Request;

class BuscadorController extends Controller
{
    public function index(Request $request)
    {
        $query = CandidatoProfile::with(['user', 'departamento', 'categoriaLaboral', 'habilidades'])
            ->whereHas('user', fn ($q) => $q->where('is_active', true));

        if ($request->filled('departamento_id')) {
            $query->where('departamento_id', $request->departamento_id);
        }

        if ($request->filled('categoria_laboral_id')) {
            $query->where('categoria_laboral_id', $request->categoria_laboral_id);
        }

        if ($request->filled('modalidad_trabajo')) {
            $query->where('modalidad_trabajo', $request->modalidad_trabajo);
        }

        if ($request->filled('habilidad_id')) {
            $query->whereHas('habilidades', fn ($q) => $q->where('habilidades.id', $request->habilidad_id));
        }

        $candidatos = $query->paginate(12)->withQueryString();

        $departamentos = Departamento::orderBy('nombre')->get();
        $categorias = CategoriaLaboral::orderBy('nombre')->get();
        $habilidades = Habilidad::orderBy('nombre')->get();

        return view('empresa.buscador.index', compact('candidatos', 'departamentos', 'categorias', 'habilidades'));
    }

    public function show(CandidatoProfile $candidato)
    {
        $candidato->load(['user', 'departamento', 'categoriaLaboral', 'habilidades', 'experiencias']);

        $solicitud = null;
        if ($candidato->visibilidad_discapacidad === 'bajo_solicitud') {
            $solicitud = SolicitudAcceso::where('empresa_user_id', auth()->id())
                ->where('candidato_profile_id', $candidato->id)
                ->first();
        }

        return view('empresa.buscador.show', compact('candidato', 'solicitud'));
    }
}
