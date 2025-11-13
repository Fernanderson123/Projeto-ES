<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Mostra o formulário de login.
     */
    public function showLoginForm()
    {
        // Se o usuário já estiver logado, redireciona para o dashboard
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('login');
    }

    /**
     * Cuida da tentativa de login.
     */
    public function login(Request $request)
    {
        // 1. Validação dos campos
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Tenta autenticar o usuário
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 3. Sucesso! Redireciona para o dashboard
            return redirect()->intended('dashboard');
        }

        // 4. Falha! Volta para o login com uma msg de erro
        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->onlyInput('email');
    }

    /**
     * Faz o logout do usuário.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}