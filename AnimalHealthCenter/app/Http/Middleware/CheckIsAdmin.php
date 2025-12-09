<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importe o Auth
use Symfony\Component\HttpFoundation\Response;

class CheckIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Verifica se está logado E se o perfil é 'Admin'
        if (Auth::check() && Auth::user()->perfil === 'Admin') {
            // 2. Se for, deixa a requisição continuar
            return $next($request);
        }

        // 3. Se não for, redireciona para o dashboard com um erro
        return redirect('/dashboard')->with('error', 'Acesso não autorizado. Você precisa ser um administrador.');
    }
}
