<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\ProntuarioController; 
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\HistoricoController;


// --- ROTAS PÚBLICAS (GUESTS) ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');

// 1. Solicitar Link
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
     ->middleware('guest')
     ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
     ->middleware('guest')
     ->name('password.email');

// 2. Redefinir Senha
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])
     ->middleware('guest')
     ->name('password.reset');

Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])
     ->middleware('guest')
     ->name('password.update');

// --- ROTAS PROTEGIDAS (SÓ ACESSA LOGADO) ---
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // --- ROTAS DE PERFIL (MINHA CONTA) ---
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil', [ProfileController::class, 'update'])->name('profile.update');

    // --- CRUDs ---
    
    // Clientes
    Route::resource('clientes', ClienteController::class);

    // Pets
    Route::resource('pets', PetController::class);

    // Produtos
    Route::resource('produtos', ProdutoController::class);
    
    // Agendamentos
    Route::resource('agendamentos', AgendamentoController::class);
    Route::patch('/agendamentos/{agendamento}/concluir', [AgendamentoController::class, 'concluir'])
         ->name('agendamentos.concluir');

    // Prontuários 
    Route::resource('prontuario', ProntuarioController::class);

    // Rota que mostra o formulário de prontuário
    Route::get('/agendamentos/{agendamento}/finalizar', [AgendamentoController::class, 'finalizar'])
     ->name('agendamentos.finalizar');
     
    // Rota que salva o prontuário e conclui o agendamento
    Route::post('/agendamentos/{agendamento}/finalizar', [AgendamentoController::class, 'storeFinalizacao'])
     ->name('agendamentos.storeFinalizacao');

    // Relatórios e Métricas
    Route::get('/relatorios', [RelatorioController::class, 'index'])->name('relatorios.index');

    Route::get('/meu-historico', [HistoricoController::class, 'index'])->name('historico.index');
    Route::get('/meu-historico/{id}', [HistoricoController::class, 'show'])->name('historico.show');

    // --- ROTAS DE GERENCIAMENTO (ADMIN) ---
    Route::middleware(['admin'])->prefix('gerenciar')->name('admin.')->group(function () {
        // Listar
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        // Criar
        Route::get('/novo', [UserController::class, 'create'])->name('users.create');
        Route::post('/novo', [UserController::class, 'store'])->name('users.store');
        // Editar
        Route::get('/{user}/editar', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
        // Reativar
        Route::put('/{user}/ativar', [UserController::class, 'activate'])->name('users.activate');
        // Excluir/Desativar
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

});

Route::get('/', function () {
    return redirect('/login');
});