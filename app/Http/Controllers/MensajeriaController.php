<?php

namespace App\Http\Controllers;

use App\Models\Conversacion;
use App\Models\Mensaje;
use App\Models\User;
use App\Notifications\NuevoMensaje;
use Illuminate\Http\Request;

class MensajeriaController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $conversaciones = Conversacion::where('empresa_user_id', $user->id)
            ->orWhere('candidato_user_id', $user->id)
            ->with(['empresa.empresaProfile', 'candidato.candidatoProfile', 'ultimoMensaje'])
            ->latest('updated_at')
            ->paginate(20);

        return view('mensajeria.index', compact('conversaciones'));
    }

    public function show(Conversacion $conversacion)
    {
        $user = auth()->user();

        if ($conversacion->empresa_user_id !== $user->id && $conversacion->candidato_user_id !== $user->id) {
            abort(403);
        }

        // Marcar mensajes del otro usuario como leídos
        $conversacion->mensajes()
            ->where('remitente_user_id', '!=', $user->id)
            ->whereNull('leido_at')
            ->update(['leido_at' => now()]);

        $conversacion->load(['empresa.empresaProfile', 'candidato.candidatoProfile']);
        $mensajes = $conversacion->mensajes()->with('remitente')->oldest()->get();

        return view('mensajeria.show', compact('conversacion', 'mensajes'));
    }

    public function store(Request $request, Conversacion $conversacion)
    {
        $user = auth()->user();

        if ($conversacion->empresa_user_id !== $user->id && $conversacion->candidato_user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'contenido' => 'required|string|max:5000',
        ]);

        $conversacion->mensajes()->create([
            'remitente_user_id' => $user->id,
            'contenido' => $validated['contenido'],
        ]);

        $conversacion->touch();

        $destinatario = $conversacion->otroUsuario($user);
        $destinatario->notify(new NuevoMensaje($conversacion, $user));

        return back()->with('success', 'Mensaje enviado.');
    }

    public function crear(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'destinatario_id' => 'required|exists:users,id',
            'asunto' => 'required|string|max:255',
            'contenido' => 'required|string|max:5000',
        ]);

        $destinatario = User::findOrFail($validated['destinatario_id']);

        // Determinar quién es empresa y quién candidato
        if ($user->role === 'empresa' && $destinatario->role === 'candidato') {
            $empresaId = $user->id;
            $candidatoId = $destinatario->id;
        } elseif ($user->role === 'candidato' && $destinatario->role === 'empresa') {
            $empresaId = $destinatario->id;
            $candidatoId = $user->id;
        } else {
            return back()->with('error', 'Solo se permite mensajería entre empresas y candidatos.');
        }

        $conversacion = Conversacion::create([
            'empresa_user_id' => $empresaId,
            'candidato_user_id' => $candidatoId,
            'asunto' => $validated['asunto'],
        ]);

        $conversacion->mensajes()->create([
            'remitente_user_id' => $user->id,
            'contenido' => $validated['contenido'],
        ]);

        $destinatario->notify(new NuevoMensaje($conversacion, $user));

        return redirect()->route('mensajeria.show', $conversacion)
            ->with('success', 'Conversación iniciada.');
    }
}
