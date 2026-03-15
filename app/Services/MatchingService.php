<?php

namespace App\Services;

use App\Models\CandidatoProfile;
use App\Models\OfertaEmpleo;
use App\Models\Postulacion;
use Illuminate\Support\Collection;

class MatchingService
{
    /**
     * Calcular puntaje de compatibilidad entre un candidato y una oferta.
     * Retorna un valor entre 0 y 100.
     */
    public function calcularPuntaje(CandidatoProfile $profile, OfertaEmpleo $oferta): int
    {
        $puntaje = 0;
        $pesoTotal = 0;

        // Categoría laboral (peso 40)
        $pesoTotal += 40;
        if ($profile->categoria_laboral_id === $oferta->categoria_laboral_id) {
            $puntaje += 40;
        }

        // Departamento (peso 20)
        $pesoTotal += 20;
        if ($profile->departamento_id === $oferta->departamento_id) {
            $puntaje += 20;
        } elseif ($oferta->modalidad === 'remoto') {
            // Si es remoto, el departamento no importa tanto
            $puntaje += 15;
        }

        // Modalidad (peso 20)
        $pesoTotal += 20;
        if ($profile->modalidad_trabajo === $oferta->modalidad) {
            $puntaje += 20;
        } elseif ($profile->modalidad_trabajo === 'hibrido' || $oferta->modalidad === 'hibrido') {
            // Híbrido es parcialmente compatible con presencial y remoto
            $puntaje += 10;
        }

        // Habilidades en común (peso 20)
        $pesoTotal += 20;
        $habilidadesIds = $profile->habilidades->pluck('id')->toArray();
        if (!empty($habilidadesIds)) {
            // Buscar cuántas habilidades del candidato aparecen en el texto de la oferta
            $habilidadesNombres = $profile->habilidades->pluck('nombre')->toArray();
            $textoOferta = strtolower($oferta->titulo . ' ' . $oferta->descripcion . ' ' . $oferta->requisitos);
            $coincidencias = 0;
            foreach ($habilidadesNombres as $hab) {
                if (str_contains($textoOferta, strtolower($hab))) {
                    $coincidencias++;
                }
            }
            if (count($habilidadesNombres) > 0) {
                $puntaje += (int) round(20 * min($coincidencias / count($habilidadesNombres), 1));
            }
        }

        return $pesoTotal > 0 ? (int) round(($puntaje / $pesoTotal) * 100) : 0;
    }

    /**
     * Obtener ofertas recomendadas para un candidato.
     */
    public function ofertasRecomendadas(CandidatoProfile $profile, int $limite = 6): Collection
    {
        $profile->load('habilidades');

        // Obtener IDs de ofertas a las que ya se postuló
        $postuladas = Postulacion::where('candidato_user_id', $profile->user_id)
            ->pluck('oferta_empleo_id')
            ->toArray();

        $ofertas = OfertaEmpleo::where('estado', 'activa')
            ->whereNotIn('id', $postuladas)
            ->with(['categoriaLaboral', 'departamento', 'empresa.empresaProfile'])
            ->get();

        return $ofertas->map(function ($oferta) use ($profile) {
            $oferta->puntaje_match = $this->calcularPuntaje($profile, $oferta);
            return $oferta;
        })
        ->where('puntaje_match', '>=', 30)
        ->sortByDesc('puntaje_match')
        ->take($limite)
        ->values();
    }

    /**
     * Obtener candidatos sugeridos para una oferta.
     */
    public function candidatosSugeridos(OfertaEmpleo $oferta, int $limite = 10): Collection
    {
        // Obtener IDs de candidatos que ya se postularon
        $yaPostulados = Postulacion::where('oferta_empleo_id', $oferta->id)
            ->pluck('candidato_user_id')
            ->toArray();

        $profiles = CandidatoProfile::whereNotIn('user_id', $yaPostulados)
            ->whereHas('user', function ($q) {
                $q->where('is_active', true);
            })
            ->with(['user', 'habilidades', 'categoriaLaboral', 'departamento'])
            ->get();

        return $profiles->map(function ($profile) use ($oferta) {
            $profile->puntaje_match = $this->calcularPuntaje($profile, $oferta);
            return $profile;
        })
        ->where('puntaje_match', '>=', 30)
        ->sortByDesc('puntaje_match')
        ->take($limite)
        ->values();
    }
}
