<?php

namespace App\Http\Controllers\Candidato;

use App\Http\Controllers\Controller;
use App\Models\OfertaEmpleo;
use App\Models\Postulacion;
use App\Notifications\NuevoPostulante;
use Illuminate\Http\Request;

class PostulacionController extends Controller
{
    public function index()
    {
        $postulaciones = auth()->user()->postulaciones()
            ->with(['oferta.empresa.empresaProfile', 'oferta.categoriaLaboral'])
            ->latest()
            ->paginate(10);

        return view('candidato.postulaciones.index', compact('postulaciones'));
    }

    public function store(Request $request, OfertaEmpleo $oferta)
    {
        if ($oferta->estado !== 'activa') {
            return back()->with('error', 'Esta oferta ya no está disponible.');
        }

        $existente = Postulacion::where('oferta_empleo_id', $oferta->id)
            ->where('candidato_user_id', auth()->id())
            ->exists();

        if ($existente) {
            return back()->with('error', 'Ya te postulaste a esta oferta.');
        }

        $validated = $request->validate([
            'mensaje' => 'nullable|string|max:2000',
        ]);

        $postulacion = Postulacion::create([
            'oferta_empleo_id' => $oferta->id,
            'candidato_user_id' => auth()->id(),
            'mensaje' => $validated['mensaje'] ?? null,
        ]);

        $oferta->empresa->notify(new NuevoPostulante($postulacion));

        return redirect()->route('candidato.postulaciones.index')
            ->with('success', 'Te postulaste correctamente.');
    }
}
