<?php

namespace App\Http\Controllers\Candidato;

use App\Http\Controllers\Controller;
use App\Models\CategoriaLaboral;
use App\Models\Departamento;
use App\Models\OfertaEmpleo;
use App\Services\MatchingService;
use Illuminate\Http\Request;

class OfertaController extends Controller
{
    public function index(Request $request)
    {
        $query = OfertaEmpleo::where('estado', 'activa')
            ->with(['empresa.empresaProfile', 'categoriaLaboral', 'departamento']);

        if ($request->filled('categoria')) {
            $query->where('categoria_laboral_id', $request->categoria);
        }

        if ($request->filled('departamento')) {
            $query->where('departamento_id', $request->departamento);
        }

        if ($request->filled('modalidad')) {
            $query->where('modalidad', $request->modalidad);
        }

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('titulo', 'like', "%{$buscar}%")
                  ->orWhere('descripcion', 'like', "%{$buscar}%");
            });
        }

        $ofertas = $query->latest()->paginate(12)->withQueryString();
        $categorias = CategoriaLaboral::orderBy('nombre')->get();
        $departamentos = Departamento::orderBy('nombre')->get();

        // Ofertas recomendadas (solo en la primera página sin filtros)
        $recomendadas = collect();
        $sinFiltros = !$request->filled('categoria') && !$request->filled('departamento')
            && !$request->filled('modalidad') && !$request->filled('buscar')
            && $request->input('page', 1) == 1;

        if ($sinFiltros) {
            $profile = auth()->user()->candidatoProfile;
            if ($profile) {
                $recomendadas = app(MatchingService::class)->ofertasRecomendadas($profile);
            }
        }

        return view('candidato.ofertas.index', compact('ofertas', 'categorias', 'departamentos', 'recomendadas'));
    }

    public function show(OfertaEmpleo $oferta)
    {
        if ($oferta->estado !== 'activa') {
            abort(404);
        }

        $oferta->load(['empresa.empresaProfile', 'categoriaLaboral', 'departamento']);

        $postulacionExistente = $oferta->postulaciones()
            ->where('candidato_user_id', auth()->id())
            ->first();

        return view('candidato.ofertas.show', compact('oferta', 'postulacionExistente'));
    }
}
