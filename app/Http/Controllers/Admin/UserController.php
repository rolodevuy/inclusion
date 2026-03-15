<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        return view('admin.usuarios.index', compact('users'));
    }

    public function toggle(User $user)
    {
        if ($user->hasRole('admin')) {
            return back()->with('error', 'No se puede desactivar un administrador.');
        }

        $user->update(['is_active' => ! $user->is_active]);

        $status = $user->is_active ? 'activado' : 'desactivado';

        return back()->with('success', "Usuario {$status} correctamente.");
    }
}
