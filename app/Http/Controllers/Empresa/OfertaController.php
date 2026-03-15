<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\CategoriaLaboral;
use App\Notifications\PostulacionEstadoCambiado;
use App\Models\Departamento;
use App\Models\OfertaEmpleo;
use Illuminate\Http\Request;

class OfertaController extends Controller
{
    public function index()
    {
        $ofertas = auth()->user()->ofertas()
            ->withCount('postulaciones')
            ->latest()
            ->paginate(10);

        return view('empresa.ofertas.index', compact('ofertas'));
    }

    public function create()
    {
        $categorias = CategoriaLaboral::orderBy('nombre')->get();
        $departamentos = Departamento::orderBy('nombre')->get();

        return view('empresa.ofertas.create', compact('categorias', 'departamentos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria_laboral_id' => 'required|exists:categorias_laborales,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'modalidad' => 'required|in:presencial,remoto,hibrido',
            'horario' => 'nullable|string|max:100',
            'requisitos' => 'nullable|string',
            'beneficios' => 'nullable|string',
            'adaptaciones_disponibles' => 'nullable|string',
        ]);

        $validated['empresa_user_id'] = auth()->id();
        $validated['estado'] = 'activa';

        OfertaEmpleo::create($validated);

        return redirect()->route('empresa.ofertas.index')
            ->with('success', 'Oferta publicada correctamente.');
    }

    public function show(OfertaEmpleo $oferta)
    {
        if ($oferta->empresa_user_id !== auth()->id()) {
            abort(403);
        }

        $oferta->load(['postulaciones.candidato.candidatoProfile', 'categoriaLaboral', 'departamento']);

        return view('empresa.ofertas.show', compact('oferta'));
    }

    public function edit(OfertaEmpleo $oferta)
    {
        if ($oferta->empresa_user_id !== auth()->id()) {
            abort(403);
        }

        $categorias = CategoriaLaboral::orderBy('nombre')->get();
        $departamentos = Departamento::orderBy('nombre')->get();

        return view('empresa.ofertas.edit', compact('oferta', 'categorias', 'departamentos'));
    }

    public function update(Request $request, OfertaEmpleo $oferta)
    {
        if ($oferta->empresa_user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria_laboral_id' => 'required|exists:categorias_laborales,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'modalidad' => 'required|in:presencial,remoto,hibrido',
            'horario' => 'nullable|string|max:100',
            'requisitos' => 'nullable|string',
            'beneficios' => 'nullable|string',
            'adaptaciones_disponibles' => 'nullable|string',
            'estado' => 'required|in:activa,pausada,cerrada',
        ]);

        $oferta->update($validated);

        return redirect()->route('empresa.ofertas.show', $oferta)
            ->with('success', 'Oferta actualizada correctamente.');
    }

    public function postulacionEstado(Request $request, OfertaEmpleo $oferta, \App\Models\Postulacion $postulacion)
    {
        if ($oferta->empresa_user_id !== auth()->id()) {
            abort(403);
        }

        if ($postulacion->oferta_empleo_id !== $oferta->id) {
            abort(404);
        }

        $validated = $request->validate([
            'estado' => 'required|in:vista,aceptada,rechazada',
        ]);

        $postulacion->update($validated);

        if (in_array($validated['estado'], ['aceptada', 'rechazada'])) {
            $postulacion->candidato->notify(new PostulacionEstadoCambiado($postulacion));
        }

        return back()->with('success', 'Estado de postulación actualizado.');
    }

    public function verCandidato(OfertaEmpleo $oferta, \App\Models\Postulacion $postulacion)
    {
        if ($oferta->empresa_user_id !== auth()->id()) {
            abort(403);
        }

        if ($postulacion->oferta_empleo_id !== $oferta->id) {
            abort(404);
        }

        $candidato = $postulacion->candidato;
        $profile = $candidato->candidatoProfile;

        if (!$profile) {
            return back()->with('error', 'Este candidato no completó su perfil.');
        }

        $profile->load(['departamento', 'categoriaLaboral', 'habilidades', 'experiencias']);

        // Determinar si puede ver info de accesibilidad
        $puedeVerAccesibilidad = false;

        if ($profile->visibilidad_discapacidad === 'publica') {
            $puedeVerAccesibilidad = true;
        } elseif ($postulacion->compartir_accesibilidad && $postulacion->estado !== 'rechazada') {
            $puedeVerAccesibilidad = true;
        } elseif ($profile->visibilidad_discapacidad === 'bajo_solicitud') {
            // Verificar si tiene solicitud aprobada
            $solicitudAprobada = $profile->solicitudesAcceso()
                ->where('empresa_user_id', auth()->id())
                ->where('estado', 'aprobada')
                ->exists();
            $puedeVerAccesibilidad = $solicitudAprobada;
        }

        return view('empresa.ofertas.candidato', compact('oferta', 'postulacion', 'candidato', 'profile', 'puedeVerAccesibilidad'));
    }
}
