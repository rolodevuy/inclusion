<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\OfertaEmpleo;
use App\Models\Postulacion;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index()
    {
        $empresaId = auth()->id();

        // Ofertas por estado
        $ofertasPorEstado = OfertaEmpleo::where('empresa_user_id', $empresaId)
            ->select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->pluck('total', 'estado');

        $totalOfertas = $ofertasPorEstado->sum();

        // Ofertas con adaptaciones
        $ofertasConAdaptaciones = OfertaEmpleo::where('empresa_user_id', $empresaId)
            ->whereNotNull('adaptaciones_disponibles')
            ->where('adaptaciones_disponibles', '!=', '')
            ->count();

        // Postulaciones totales a mis ofertas
        $ofertaIds = OfertaEmpleo::where('empresa_user_id', $empresaId)->pluck('id');

        $postulacionesPorEstado = Postulacion::whereIn('oferta_empleo_id', $ofertaIds)
            ->select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->pluck('total', 'estado');

        $totalPostulaciones = $postulacionesPorEstado->sum();

        // Tasa de aceptación
        $aceptadas = $postulacionesPorEstado->get('aceptada', 0);
        $rechazadas = $postulacionesPorEstado->get('rechazada', 0);
        $resueltas = $aceptadas + $rechazadas;
        $tasaAceptacion = $resueltas > 0 ? round(($aceptadas / $resueltas) * 100) : null;

        // Postulaciones por mes (últimos 6 meses)
        $postulacionesPorMes = Postulacion::whereIn('oferta_empleo_id', $ofertaIds)
            ->where('created_at', '>=', now()->subMonths(6))
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as mes"),
                DB::raw('count(*) as total')
            )
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes');

        // Top ofertas con más postulaciones
        $topOfertas = OfertaEmpleo::where('empresa_user_id', $empresaId)
            ->withCount('postulaciones')
            ->orderByDesc('postulaciones_count')
            ->limit(5)
            ->get();

        // Postulaciones por categoría laboral
        $porCategoria = OfertaEmpleo::where('empresa_user_id', $empresaId)
            ->join('postulaciones', 'ofertas_empleo.id', '=', 'postulaciones.oferta_empleo_id')
            ->join('categorias_laborales', 'ofertas_empleo.categoria_laboral_id', '=', 'categorias_laborales.id')
            ->select('categorias_laborales.nombre', DB::raw('count(postulaciones.id) as total'))
            ->groupBy('categorias_laborales.nombre')
            ->orderByDesc('total')
            ->pluck('total', 'nombre');

        // Candidatos que compartieron info de accesibilidad
        $compartieronAccesibilidad = Postulacion::whereIn('oferta_empleo_id', $ofertaIds)
            ->where('compartir_accesibilidad', true)
            ->count();

        return view('empresa.reportes.index', compact(
            'ofertasPorEstado',
            'totalOfertas',
            'ofertasConAdaptaciones',
            'postulacionesPorEstado',
            'totalPostulaciones',
            'tasaAceptacion',
            'aceptadas',
            'rechazadas',
            'resueltas',
            'postulacionesPorMes',
            'topOfertas',
            'porCategoria',
            'compartieronAccesibilidad',
        ));
    }
}
