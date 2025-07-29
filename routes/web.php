<?php

use App\Http\Controllers\AutocompleteController;
use App\Http\Controllers\AvaliacaoDesempenhoGestorController;
use App\Http\Controllers\AvaliacaoDesempenhoServidorController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServidorController;
use App\Http\Controllers\ServidorDependenteController;
use App\Http\Controllers\ServidorFormacaoController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

URL::forceScheme(env('HTTP_SCHEMA'));
URL::forceRootUrl(env('APP_URL'));

Route::middleware([Authenticate::class])->group(function() {
    //Route::get('/', function () { return view('home');});
    // Route::get('/home', function () { return view('home'); })->middleware(['auth', 'verified'])->name('home');
    //Route::get('/home', [ServidorController::class, 'home'])->name('home');
    Route::get('/', [ServidorController::class, 'home'])->name('home');


    Route::get('/info', function () {
    phpinfo();
});

    Route::get('/info_pessoal', [ServidorController::class, 'edit'])->name('servidores.servidor_edit');
    Route::post('/info_pessoal_update', [ServidorController::class, 'update'])->name('servidores.servidor_info_pessoal_update');
    
    Route::get('/servidor_dependentes_create', [ServidorDependenteController::class, 'create'])->name('servidores.servidor_dependentes_create');
    Route::get('/servidor_dependentes_edit/{id}', [ServidorDependenteController::class, 'edit'])->name('servidores.servidor_dependentes_edit');
    Route::post('/servidor_dependentes_store', [ServidorDependenteController::class, 'store'])->name('servidores.servidor_dependentes_store');
    Route::get('/servidor_dependentes_lista', [ServidorDependenteController::class, 'index'])->name('servidores.servidor_dependentes_lista');
    Route::post('/servidor_dependentes_update', [ServidorDependenteController::class, 'update'])->name('servidores.servidor_dependentes_update');
    Route::post('/servidores/dependentes/reativar', [ServidorDependenteController::class, 'reativar'])->name('servidores.dependentes.reativar');   
    Route::get('/servidores/dependentes/reativar_dependente/{id}', [ServidorDependenteController::class, 'reativarDependente'])->name('servidores.dependentes.reativar_dependente');   
    
    Route::get('/servidor_formacao_list', [ServidorFormacaoController::class, 'index'])->name('servidores.formacao.list');
    Route::get('/servidor_formacao_create', [ServidorFormacaoController::class, 'create'])->name('servidores.formacao.create');
    Route::post('/servidor_formacao_store', [ServidorFormacaoController::class, 'store'])->name('servidores.formacao.store');
    Route::put('/servidor_formacao/{servidorFormacao}', [ServidorFormacaoController::class, 'update'])
    ->name('servidores.formacao.update');
    Route::get('/servidor_formacao_edit/{id}', [ServidorFormacaoController::class, 'edit'])->name('servidores.formacao.edit');

    Route::post('/servidor_dependentes_inativar', [ServidorDependenteController::class, 'destroy'])->name('servidores.servidor_dependentes_inativar');
    Route::get('/servidor_dependentes_lista_inativo', [ServidorDependenteController::class, 'show'])->name('servidores.servidor_dependentes_lista_inativo');
    
    Route::get('/avaliacao_desempenho_servidor_lista', [AvaliacaoDesempenhoServidorController::class, 'index'])->name('servidores.avaliacao_desempenho_servidor_lista');
    Route::get('/ficha_avaliacao_servidor/{id}/{mes}/{ano}', [AvaliacaoDesempenhoServidorController::class, 'show'])->name('servidores.ficha_avaliacao_servidor');    
    Route::get('/avaliacao_desempenho_gestor_lista', [AvaliacaoDesempenhoGestorController::class, 'index'])->name('servidores.avaliacao_desempenho_gestor_lista');
    Route::get('/ficha_avaliacao_gestor/{id}/{mes}/{ano}', [AvaliacaoDesempenhoGestorController::class, 'show'])->name('servidores.ficha_avaliacao_gestor'); 

    Route::post('/bairros/fetch', [CidadeController::class, 'fetch'])->name('bairros.fetch');
    Route::get('/autocomplete', [AutocompleteController::class, 'index']);
    Route::post('/autocomplete/fetch', [AutocompleteController::class, 'fetch'])->name('autocomplete.fetch');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});
