<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\AgendamentoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- ROTAS PÚBLICAS (GUESTS) ---
// Qualquer um pode acessar (Login e Registro)

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Registro (PRECISA estar fora do 'auth' para novos usuários criarem conta)
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');


// --- ROTAS PROTEGIDAS (SÓ ACESSA LOGADO) ---
Route::middleware(['auth'])->group(function () {

    // Logout (Só quem está logado pode sair)
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // --- ROTAS DE PERFIL (MINHA CONTA) ---
    Route::get('/perfil', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    // --- ROTAS FUNCIONAIS (CRUDs) ---

    // Clientes (Agora usando o Controller real)
    Route::resource('clientes', ClienteController::class);

    // CRUD de Clientes
    Route::resource('clientes', ClienteController::class);

    // CRUD de Pets 
    Route::resource('pets', PetController::class);

    // CRUD de Produtos 
    Route::resource('produtos', ProdutoController::class);

    Route::resource('agendamentos', AgendamentoController::class);

    Route::patch('/agendamentos/{agendamento}/concluir', [AgendamentoController::class, 'concluir']) ->name('agendamentos.concluir');

    // --- Rotas de Placeholder (Estáticas por enquanto) ---
    // Estas rotas seguram os botões do dashboard para não dar erro 404
    // Futuramente, trocaremos por Controllers reais (PetController, etc.)
    
    Route::get('/prontuario', function () { 
        return view('prontuario.index'); 
    })->name('prontuario.index');
    
    Route::get('/relatorios', function () { 
        return view('relatorios.index'); 
    })->name('relatorios.index');
    
    Route::get('/historico-consultas', function () { 
        return view('historico_consultas.index'); 
    })->name('historico_consultas.index');


    // --- ROTAS DE ADMIN (SÓ ADMIN ACESSA) ---
   Route::middleware(['admin'])->prefix('gerenciar')->name('admin.')->group(function () {
        
        // Listar Usuários (Index)
        Route::get('/', [UserController::class, 'index'])->name('users.index'); // admin.users.index

        // Criar Usuário (Create & Store)
        Route::get('/novo', [UserController::class, 'create'])->name('users.create');
        Route::post('/novo', [UserController::class, 'store'])->name('users.store');

        // Editar
        Route::get('/{user}/editar', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
    
        // NOVO: Reativar Usuário
        Route::put('/{user}/ativar', [UserController::class, 'activate'])->name('users.activate');

        // Excluir/Desativar
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

}); // Fim do grupo principal de middleware 'auth'


// Redireciona a raiz "/" para a página de login
Route::get('/', function () {
    return redirect('/login');
});