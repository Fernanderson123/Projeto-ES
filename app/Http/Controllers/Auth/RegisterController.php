<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Importe o Model User
use Illuminate\Support\Facades\Hash; // Importe o Hash
use Illuminate\Support\Facades\Auth; // Importe o Auth

class RegisterController extends Controller
{
    /**
     * Mostra o formulário de registro.
     */
    public function showRegistrationForm()
    {
        return view('register');
    }

    /**
     * Processa o formulário de registro.
     */
   public function register(Request $request)
    {
        // 1. Validação
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 2. Cria o usuário (definindo o perfil manualmente)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'perfil' => 'Cliente', // <-- AQUI A REGRA DE NEGÓCIO
        ]);

        // 3. Loga o usuário automaticamente
        Auth::login($user);

        // 4. Redireciona para o dashboard com a mensagem de sucesso
        return redirect('/dashboard')->with('success', 'Sua conta de Cliente foi criada com sucesso!');
    }
}