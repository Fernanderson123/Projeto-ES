<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Importe o Model User
use Illuminate\Support\Facades\Auth; // Importe o Auth

class UserController extends Controller
{
    /**
     * Lista todos os usuários.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Remove um usuário específico.
     */
    public function destroy(User $user) // O Laravel encontra o usuário pelo ID
    {
        // REGRA DE SEGURANÇA: Impede que o admin exclua a si mesmo
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Você não pode excluir sua própria conta!');
        }

        $user->delete();
        return back()->with('success', 'Usuário excluído com sucesso!');
    }
}