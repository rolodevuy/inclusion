<?php

namespace App\Http\Controllers\Candidato;

use App\Http\Controllers\Controller;
use App\Models\SolicitudAcceso;

class SolicitudController extends Controller
{
    public function index()
    {
        $profile = auth()->user()->candidatoProfile;

        if (! $profile) {
            return redirect()->route('candidato.perfil.create');
        }

        $solicitudes = SolicitudAcceso::where('candidato_profile_id', $profile->id)
            ->with('empresa.empresaProfile')
            ->orderByRaw("FIELD(estado, 'pendiente', 'aprobada', 'rechazada')")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('candidato.solicitudes.index', compact('solicitudes'));
    }

    public function aprobar(SolicitudAcceso $solicitud)
    {
        $this->authorize($solicitud);

        $solicitud->update(['estado' => 'aprobada']);

        return back()->with('success', 'Solicitud aprobada. La empresa podrá ver tu información de accesibilidad.');
    }

    public function rechazar(SolicitudAcceso $solicitud)
    {
        $this->authorize($solicitud);

        $solicitud->update(['estado' => 'rechazada']);

        return back()->with('success', 'Solicitud rechazada.');
    }

    private function authorize(SolicitudAcceso $solicitud): void
    {
        $profile = auth()->user()->candidatoProfile;

        if (! $profile || $solicitud->candidato_profile_id !== $profile->id) {
            abort(403);
        }
    }
}
