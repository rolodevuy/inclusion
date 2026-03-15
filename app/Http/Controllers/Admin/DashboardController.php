<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CandidatoProfile;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_candidatos' => User::where('role', 'candidato')->count(),
            'total_empresas' => User::where('role', 'empresa')->count(),
            'candidatos_con_perfil' => CandidatoProfile::count(),
            'candidatos_por_departamento' => CandidatoProfile::selectRaw('departamento_id, count(*) as total')
                ->groupBy('departamento_id')
                ->with('departamento')
                ->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
