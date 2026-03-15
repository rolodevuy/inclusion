<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\CandidatoProfile;
use App\Models\SolicitudAcceso;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    public function store(Request $request, CandidatoProfile $candidato)
    {
        if ($candidato->visibilidad_discapacidad !== 'bajo_solicitud') {
            return back()->with('error', 'Este candidato no tiene información bajo solicitud.');
        }

        $existing = SolicitudAcceso::where('empresa_user_id', auth()->id())
            ->where('candidato_profile_id', $candidato->id)
            ->first();

        if ($existing && $existing->estado === 'pendiente') {
            return back()->with('error', 'Ya tenés una solicitud pendiente con este candidato.');
        }

        if ($existing && $existing->estado === 'aprobada') {
            return back()->with('error', 'Ya tenés acceso a la información de este candidato.');
        }

        // Si fue rechazada, eliminar la anterior para permitir reintento
        if ($existing && $existing->estado === 'rechazada') {
            $existing->delete();
        }

        $validated = $request->validate([
            'mensaje' => 'nullable|string|max:500',
        ]);

        SolicitudAcceso::create([
            'empresa_user_id' => auth()->id(),
            'candidato_profile_id' => $candidato->id,
            'estado' => 'pendiente',
            'mensaje' => $validated['mensaje'] ?? null,
        ]);

        return back()->with('success', 'Solicitud enviada. El candidato será notificado.');
    }
}
