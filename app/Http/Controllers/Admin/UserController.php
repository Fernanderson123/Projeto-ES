<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Lista todos os usuários (Página /gerenciar).
     */
    public function index()
    {
        // Ordena por ID descrescente para ver os novos primeiro
        $users = User::orderBy('id', 'asc')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Mostra o formulário de criar novo usuário interno.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Salva o novo usuário no banco.
     */
    public function store(Request $request)
    {
        // 1. Validação
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'perfil' => 'required|in:Admin,Recepcionista,Veterinário,Investidor,Cliente',
        ]);

        // 2. Criação
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'perfil' => $request->perfil,
        ]);

        // SE O PERFIL FOR CLIENTE, CRIA O REGISTRO NA TABELA CLIENTES
        if ($request->perfil === 'Cliente') {
            \App\Models\Cliente::create([
                'user_id' => $user->id,
                'nome_completo' => $user->name,
                'email' => $user->email,
                'cpf' => 'Gerado pelo Admin ' . uniqid(), // Placeholder temporário para passar na unique do banco, ou altere a migration para nullable
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Usuário cadastrado!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Atualiza o usuário no banco.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)],
            'perfil' => 'required|in:Admin,Recepcionista,Veterinário,Investidor,Cliente',
            'password' => 'nullable|string|min:6',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->perfil = $request->perfil;

        // Só atualiza a senha se foi preenchida
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        // Se quiser permitir reativar manualmente na edição, pode adicionar aqui
        // $user->active = $request->boolean('active'); 

        $user->save();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove um usuário.
     */
    public function destroy(User $user)
    {
        // Segurança: Não pode desativar a si mesmo
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Você não pode desativar sua própria conta!');
        }

        // SE estiver ATIVO -> DESATIVA
        if ($user->active) {
            $user->active = false;
            $user->save();
            return back()->with('success', 'Usuário desativado com sucesso.');
        }

        // SE JÁ estiver DESATIVADO -> EXCLUI DEFINITIVAMENTE
        $user->delete();
        return back()->with('success', 'Usuário excluído permanentemente.');
    }
    
    /**
     * Reativa um usuário desativado.
     */
    public function activate(User $user)
    {
        $user->active = true;
        $user->save();
        return back()->with('success', 'Usuário reativado com sucesso!');
    }
}