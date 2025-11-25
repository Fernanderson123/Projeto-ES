<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'marca',      // Novo
        'descricao',
        'unidade',
        'estoque',
        'preco_custo',
        'preco_venda',
        'validade',   // Novo
    ];
    
    // Cast para garantir que validade seja tratada como data
    protected $casts = [
        'validade' => 'date',
    ];
}