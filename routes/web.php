<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aqui é onde você pode registrar as rotas web para sua aplicação.
|
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

    // --- Rotas de Placeholder para os botões do Dashboard ---
    // (Estas são as páginas que cada perfil pode acessar)

    Route::get('/clientes', function () { 
        return view('clientes.index'); 
    })->name('clientes.index');
    
    Route::get('/pets', function () { 
        return view('pets.index'); 
    })->name('pets.index');
    
    Route::get('/agendamentos', function () { 
        return view('agendamentos.index'); 
    })->name('agendamentos.index');
    
    Route::get('/prontuario', function () { 
        return view('prontuario.index'); 
    })->name('prontuario.index');
    
    Route::get('/produtos', function () { 
        return view('produtos.index'); 
    })->name('produtos.index');
    
    // Rota de Medicamentos foi REMOVIDA, pois foi unificada com Produtos.
    
    Route::get('/gerenciar', function () { 
        return view('gerenciar.index'); 
    })->name('gerenciar.index');
    
    Route::get('/relatorios', function () { 
        return view('relatorios.index'); 
    })->name('relatorios.index');
    
    Route::get('/historico-consultas', function () { 
        return view('historico_consultas.index'); 
    })->name('historico_consultas.index');


    // --- ROTAS DE ADMIN (SÓ ADMIN ACESSA) ---
    // Estas rotas já herdam o 'auth' do grupo pai, então só checamos 'admin'
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        
        // Rota para listar usuários
        Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');

        // Rota para excluir usuário
        Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

}); // Fim do grupo principal de middleware 'auth'


// Redireciona a raiz "/" para a página de login
Route::get('/', function () {
    return redirect('/login');
});