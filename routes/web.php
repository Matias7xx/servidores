<?php

use App\Http\Controllers\AutocompleteController;
use App\Http\Controllers\AvaliacaoDesempenhoGestorController;
use App\Http\Controllers\AvaliacaoDesempenhoServidorController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\FormacaoClasseController;
use App\Http\Controllers\FormacaoCursoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServidorController;
use App\Http\Controllers\ServidorDependenteController;
use App\Http\Controllers\ServidorFormacaoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

URL::forceScheme(env('HTTP_SCHEMA'));
URL::forceRootUrl(env('APP_URL'));

// ===== ROTAS PÚBLICAS (SEM AUTENTICAÇÃO) =====

// Rota de Login (POST)
Route::post('/login', function() {
    $credentials = request()->only('matricula', 'password');

    if (Auth::attempt($credentials, request()->filled('remember'))) {
        request()->session()->regenerate();

        return response()->json([
            'success' => true,
            'user' => auth()->user()
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Credenciais inválidas'
    ], 401);
})->name('login');

Route::get('/sanctum/csrf-cookie', function() {
    return response()->json(['success' => true]);
});

// ===== ROTAS PROTEGIDAS (REQUER AUTENTICAÇÃO) =====

Route::middleware(['auth'])->group(function() {

    // API User
    Route::get('/api/user', function() {
        return response()->json(auth()->user());
    });

    // Logout
    Route::post('/logout', function() {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Logout realizado com sucesso'
        ]);
    })->name('logout');

    // API Informações Pessoais
    Route::get('/api/info_pessoal', [ServidorController::class, 'edit'])->name('servidores.servidor_edit');
    Route::post('/api/info_pessoal_update', [ServidorController::class, 'update'])->name('servidores.servidor_info_pessoal_update');

    // API Dependentes
    Route::prefix('api/dependentes')->group(function() {
        Route::get('/', [ServidorDependenteController::class, 'index'])->name('dependentes.index');
        Route::get('/inativos', [ServidorDependenteController::class, 'show'])->name('dependentes.inativos');
        Route::get('/create', [ServidorDependenteController::class, 'create'])->name('dependentes.create');
        Route::post('/', [ServidorDependenteController::class, 'store'])->name('dependentes.store');
        Route::get('/{id}/edit', [ServidorDependenteController::class, 'edit'])->name('dependentes.edit');
        Route::post('/update', [ServidorDependenteController::class, 'update'])->name('dependentes.update');
        Route::post('/inativar', [ServidorDependenteController::class, 'destroy'])->name('dependentes.destroy');
        Route::post('/reativar', [ServidorDependenteController::class, 'reativar'])->name('dependentes.reativar');
        Route::get('/reativar/{id}', [ServidorDependenteController::class, 'reativarDependente'])->name('dependentes.reativar_direto');
    });

    // API Formação
    Route::prefix('api')->group(function() {
        Route::get('/servidor_formacao_list', [ServidorFormacaoController::class, 'index'])->name('servidor_formacao_list');
        Route::get('/servidor_formacao_create', [ServidorFormacaoController::class, 'create'])->name('servidor_formacao_create');
        Route::post('/servidor_formacao_store', [ServidorFormacaoController::class, 'store'])->name('servidor_formacao_store');
        Route::get('/servidor_formacao_edit/{id}', [ServidorFormacaoController::class, 'edit'])->name('servidor_formacao_edit');
        Route::post('/servidor_formacao_update', [ServidorFormacaoController::class, 'update'])->name('servidor_formacao_update');
        Route::post('/servidor_formacao_inativar', [ServidorFormacaoController::class, 'destroy'])->name('servidor_formacao_inativar');

        // Rotas auxiliares de Formação
        Route::get('/formacao/classes/{area_id}', [FormacaoClasseController::class, 'getClassesByArea'])->name('formacao.classes');
        Route::get('/formacao/cursos/{classe_id}', [FormacaoCursoController::class, 'getCursosByClasse'])->name('formacao.cursos');
    });

    // Outras rotas
    Route::get('/servidor_dependentes_lista_inativo', [ServidorDependenteController::class, 'show'])->name('servidores.servidor_dependentes_lista_inativo');

    Route::get('/avaliacao_desempenho_servidor_lista', [AvaliacaoDesempenhoServidorController::class, 'index'])->name('servidores.avaliacao_desempenho_servidor_lista');
    Route::get('/ficha_avaliacao_servidor/{id}/{mes}/{ano}', [AvaliacaoDesempenhoServidorController::class, 'show'])->name('servidores.ficha_avaliacao_servidor');
    Route::get('/avaliacao_desempenho_gestor_lista', [AvaliacaoDesempenhoGestorController::class, 'index'])->name('servidores.avaliacao_desempenho_gestor_lista');
    Route::get('/ficha_avaliacao_gestor/{id}/{mes}/{ano}', [AvaliacaoDesempenhoGestorController::class, 'show'])->name('servidores.ficha_avaliacao_gestor');

    Route::post('/bairros/fetch', [CidadeController::class, 'fetch'])->name('bairros.fetch');
    Route::get('/autocomplete', [AutocompleteController::class, 'index']);
    Route::post('/autocomplete/fetch', [AutocompleteController::class, 'fetch'])->name('autocomplete.fetch');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
