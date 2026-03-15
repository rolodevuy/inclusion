<?php

use App\Http\Controllers\Admin\CatalogoController;
use App\Http\Controllers\Admin\CertificadoController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Candidato\ExperienciaController;
use App\Http\Controllers\Candidato\OfertaController as CandidatoOfertaController;
use App\Http\Controllers\Candidato\PostulacionController;
use App\Http\Controllers\Candidato\ProfileController as CandidatoProfileController;
use App\Http\Controllers\Candidato\SolicitudController as CandidatoSolicitudController;
use App\Http\Controllers\Empresa\BuscadorController;
use App\Http\Controllers\Empresa\OfertaController as EmpresaOfertaController;
use App\Http\Controllers\Empresa\ReporteController;
use App\Http\Controllers\Empresa\ProfileController as EmpresaProfileController;
use App\Http\Controllers\Empresa\SolicitudController as EmpresaSolicitudController;
use App\Http\Controllers\MensajeriaController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Públicas
Route::get('/', [PageController::class, 'landing'])->name('landing');

// Dashboard — redirige según rol
Route::get('/dashboard', function () {
    $user = auth()->user();

    return match ($user->role) {
        'candidato' => redirect()->route('candidato.perfil.show'),
        'empresa' => redirect()->route('empresa.perfil.show'),
        'admin' => redirect()->route('admin.dashboard'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

// Breeze profile (cuenta)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Candidato
Route::middleware(['auth', 'role:candidato'])->prefix('candidato')->name('candidato.')->group(function () {
    Route::get('/perfil', [CandidatoProfileController::class, 'show'])->name('perfil.show');
    Route::get('/perfil/crear', [CandidatoProfileController::class, 'create'])->name('perfil.create');
    Route::post('/perfil', [CandidatoProfileController::class, 'store'])->name('perfil.store');
    Route::get('/perfil/editar', [CandidatoProfileController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil', [CandidatoProfileController::class, 'update'])->name('perfil.update');

    Route::get('/experiencias/crear', [ExperienciaController::class, 'create'])->name('experiencias.create');
    Route::post('/experiencias', [ExperienciaController::class, 'store'])->name('experiencias.store');
    Route::get('/experiencias/{experiencia}/editar', [ExperienciaController::class, 'edit'])->name('experiencias.edit');
    Route::put('/experiencias/{experiencia}', [ExperienciaController::class, 'update'])->name('experiencias.update');
    Route::delete('/experiencias/{experiencia}', [ExperienciaController::class, 'destroy'])->name('experiencias.destroy');

    Route::get('/solicitudes', [CandidatoSolicitudController::class, 'index'])->name('solicitudes.index');
    Route::patch('/solicitudes/{solicitud}/aprobar', [CandidatoSolicitudController::class, 'aprobar'])->name('solicitudes.aprobar');
    Route::patch('/solicitudes/{solicitud}/rechazar', [CandidatoSolicitudController::class, 'rechazar'])->name('solicitudes.rechazar');

    Route::get('/ofertas', [CandidatoOfertaController::class, 'index'])->name('ofertas.index');
    Route::get('/ofertas/{oferta}', [CandidatoOfertaController::class, 'show'])->name('ofertas.show');
    Route::post('/ofertas/{oferta}/postular', [PostulacionController::class, 'store'])->name('postulaciones.store');
    Route::get('/postulaciones', [PostulacionController::class, 'index'])->name('postulaciones.index');

    Route::get('/empresa/{user}', function (\App\Models\User $user) {
        if ($user->role !== 'empresa') {
            abort(404);
        }
        $profile = $user->empresaProfile;
        if (!$profile) {
            abort(404);
        }
        $profile->load('departamento');
        $ofertasActivas = $user->ofertas()->where('estado', 'activa')
            ->with(['categoriaLaboral', 'departamento'])->get();
        $empresa = $user;
        return view('candidato.empresa.show', compact('empresa', 'profile', 'ofertasActivas'));
    })->name('empresa.ver');
});

// Empresa
Route::middleware(['auth', 'role:empresa'])->prefix('empresa')->name('empresa.')->group(function () {
    Route::get('/perfil', [EmpresaProfileController::class, 'show'])->name('perfil.show');
    Route::get('/perfil/crear', [EmpresaProfileController::class, 'create'])->name('perfil.create');
    Route::post('/perfil', [EmpresaProfileController::class, 'store'])->name('perfil.store');
    Route::get('/perfil/editar', [EmpresaProfileController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil', [EmpresaProfileController::class, 'update'])->name('perfil.update');

    Route::get('/buscador', [BuscadorController::class, 'index'])->name('buscador.index');
    Route::get('/candidato/{candidato}', [BuscadorController::class, 'show'])->name('buscador.show');
    Route::post('/candidato/{candidato}/solicitar', [EmpresaSolicitudController::class, 'store'])->name('solicitud.store');

    Route::get('/ofertas', [EmpresaOfertaController::class, 'index'])->name('ofertas.index');
    Route::get('/ofertas/crear', [EmpresaOfertaController::class, 'create'])->name('ofertas.create');
    Route::post('/ofertas', [EmpresaOfertaController::class, 'store'])->name('ofertas.store');
    Route::get('/ofertas/{oferta}', [EmpresaOfertaController::class, 'show'])->name('ofertas.show');
    Route::get('/ofertas/{oferta}/editar', [EmpresaOfertaController::class, 'edit'])->name('ofertas.edit');
    Route::put('/ofertas/{oferta}', [EmpresaOfertaController::class, 'update'])->name('ofertas.update');
    Route::patch('/ofertas/{oferta}/postulaciones/{postulacion}', [EmpresaOfertaController::class, 'postulacionEstado'])->name('ofertas.postulacion.estado');
    Route::get('/ofertas/{oferta}/postulaciones/{postulacion}/candidato', [EmpresaOfertaController::class, 'verCandidato'])->name('ofertas.postulacion.candidato');

    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
});

// Mensajería (candidato y empresa)
Route::middleware(['auth'])->prefix('mensajes')->name('mensajeria.')->group(function () {
    Route::get('/', [MensajeriaController::class, 'index'])->name('index');
    Route::post('/nueva', [MensajeriaController::class, 'crear'])->name('crear');
    Route::get('/{conversacion}', [MensajeriaController::class, 'show'])->name('show');
    Route::post('/{conversacion}', [MensajeriaController::class, 'store'])->name('store');
});

// Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::patch('/usuarios/{user}/toggle', [UserController::class, 'toggle'])->name('usuarios.toggle');

    Route::get('/catalogos', [CatalogoController::class, 'index'])->name('catalogos.index');
    Route::post('/catalogos/categorias', [CatalogoController::class, 'storeCategoria'])->name('catalogos.categorias.store');
    Route::put('/catalogos/categorias/{categoria}', [CatalogoController::class, 'updateCategoria'])->name('catalogos.categorias.update');
    Route::delete('/catalogos/categorias/{categoria}', [CatalogoController::class, 'destroyCategoria'])->name('catalogos.categorias.destroy');
    Route::post('/catalogos/habilidades', [CatalogoController::class, 'storeHabilidad'])->name('catalogos.habilidades.store');
    Route::put('/catalogos/habilidades/{habilidad}', [CatalogoController::class, 'updateHabilidad'])->name('catalogos.habilidades.update');
    Route::delete('/catalogos/habilidades/{habilidad}', [CatalogoController::class, 'destroyHabilidad'])->name('catalogos.habilidades.destroy');

    Route::get('/certificados', [CertificadoController::class, 'index'])->name('certificados.index');
    Route::get('/certificados/{profile}/descargar', [CertificadoController::class, 'descargar'])->name('certificados.descargar');
    Route::patch('/certificados/{profile}/verificar', [CertificadoController::class, 'verificar'])->name('certificados.verificar');
    Route::patch('/certificados/{profile}/rechazar', [CertificadoController::class, 'rechazar'])->name('certificados.rechazar');
});

require __DIR__.'/auth.php';
