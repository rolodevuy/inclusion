<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CandidatoProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificadoController extends Controller
{
    public function index()
    {
        $pendientes = CandidatoProfile::where('certificado_estado', 'pendiente')
            ->with('user')
            ->latest('updated_at')
            ->get();

        $revisados = CandidatoProfile::whereIn('certificado_estado', ['verificado', 'rechazado'])
            ->with('user')
            ->latest('updated_at')
            ->limit(20)
            ->get();

        return view('admin.certificados.index', compact('pendientes', 'revisados'));
    }

    public function descargar(CandidatoProfile $profile)
    {
        if (!$profile->certificado_path || !Storage::disk('local')->exists($profile->certificado_path)) {
            abort(404, 'Certificado no encontrado.');
        }

        return Storage::disk('local')->download($profile->certificado_path, "certificado-{$profile->user->name}.{$this->getExtension($profile->certificado_path)}");
    }

    public function verificar(CandidatoProfile $profile)
    {
        $profile->update([
            'certificado_estado' => 'verificado',
            'certificado_observaciones' => null,
        ]);

        return back()->with('success', "Certificado de {$profile->user->name} verificado.");
    }

    public function rechazar(Request $request, CandidatoProfile $profile)
    {
        $validated = $request->validate([
            'certificado_observaciones' => 'required|string|max:500',
        ]);

        $profile->update([
            'certificado_estado' => 'rechazado',
            'certificado_observaciones' => $validated['certificado_observaciones'],
        ]);

        return back()->with('success', "Certificado de {$profile->user->name} rechazado.");
    }

    private function getExtension(string $path): string
    {
        return pathinfo($path, PATHINFO_EXTENSION);
    }
}
