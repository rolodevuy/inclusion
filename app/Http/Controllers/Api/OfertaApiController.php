<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CandidatoProfile;
use App\Models\CategoriaLaboral;
use App\Models\Departamento;
use App\Models\OfertaEmpleo;
use App\Models\User;
use Illuminate\Http\Request;

class OfertaApiController extends Controller
{
    /**
     * Listar ofertas activas con filtros opcionales.
     *
     * GET /api/ofertas?categoria=1&departamento=3&modalidad=remoto&buscar=texto&page=1
     */
    public function index(Request $request)
    {
        $query = OfertaEmpleo::where('estado', 'activa')
            ->with(['categoriaLaboral:id,nombre', 'departamento:id,nombre', 'empresa.empresaProfile:id,user_id,rut,sector']);

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

        $ofertas = $query->latest()->paginate(15);

        return response()->json($ofertas);
    }

    /**
     * Ver detalle de una oferta activa.
     *
     * GET /api/ofertas/{id}
     */
    public function show(OfertaEmpleo $oferta)
    {
        if ($oferta->estado !== 'activa') {
            return response()->json(['message' => 'Oferta no disponible.'], 404);
        }

        $oferta->load([
            'categoriaLaboral:id,nombre',
            'departamento:id,nombre',
            'empresa.empresaProfile:id,user_id,rut,sector,descripcion,sitio_web',
        ]);

        return response()->json($oferta);
    }

    /**
     * Estadísticas generales de la plataforma.
     *
     * GET /api/estadisticas
     */
    public function estadisticas()
    {
        return response()->json([
            'ofertas_activas' => OfertaEmpleo::where('estado', 'activa')->count(),
            'total_ofertas' => OfertaEmpleo::count(),
            'empresas_registradas' => User::where('role', 'empresa')->where('is_active', true)->count(),
            'candidatos_registrados' => User::where('role', 'candidato')->where('is_active', true)->count(),
            'categorias_laborales' => CategoriaLaboral::count(),
            'departamentos' => Departamento::count(),
        ]);
    }

    /**
     * Listar categorías laborales.
     *
     * GET /api/categorias
     */
    public function categorias()
    {
        return response()->json(
            CategoriaLaboral::orderBy('nombre')->get(['id', 'nombre'])
        );
    }

    /**
     * Listar departamentos.
     *
     * GET /api/departamentos
     */
    public function departamentos()
    {
        return response()->json(
            Departamento::orderBy('nombre')->get(['id', 'nombre'])
        );
    }
}
