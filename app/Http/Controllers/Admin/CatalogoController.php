<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoriaLaboral;
use App\Models\Habilidad;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    public function index()
    {
        $categorias = CategoriaLaboral::withCount('habilidades')->orderBy('nombre')->get();
        $habilidades = Habilidad::with('categoriaLaboral')->orderBy('nombre')->get();

        return view('admin.catalogos.index', compact('categorias', 'habilidades'));
    }

    // --- Categorías ---

    public function storeCategoria(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias_laborales,nombre',
        ]);

        CategoriaLaboral::create($validated);

        return back()->with('success', 'Categoría creada correctamente.');
    }

    public function updateCategoria(Request $request, CategoriaLaboral $categoria)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias_laborales,nombre,' . $categoria->id,
        ]);

        $categoria->update($validated);

        return back()->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroyCategoria(CategoriaLaboral $categoria)
    {
        if ($categoria->habilidades()->count() > 0) {
            return back()->with('error', 'No se puede eliminar una categoría que tiene habilidades asociadas.');
        }

        $categoria->delete();

        return back()->with('success', 'Categoría eliminada correctamente.');
    }

    // --- Habilidades ---

    public function storeHabilidad(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'categoria_laboral_id' => 'nullable|exists:categorias_laborales,id',
        ]);

        Habilidad::create($validated);

        return back()->with('success', 'Habilidad creada correctamente.');
    }

    public function updateHabilidad(Request $request, Habilidad $habilidad)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'categoria_laboral_id' => 'nullable|exists:categorias_laborales,id',
        ]);

        $habilidad->update($validated);

        return back()->with('success', 'Habilidad actualizada correctamente.');
    }

    public function destroyHabilidad(Habilidad $habilidad)
    {
        $habilidad->delete();

        return back()->with('success', 'Habilidad eliminada correctamente.');
    }
}
