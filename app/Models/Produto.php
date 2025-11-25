<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'marca',      // Campo para Marca/Laboratório
        'descricao',
        'unidade',
        'estoque',
        'preco_custo',
        'preco_venda',
        'validade',   // Campo para Data de Validade
    ];
    
    // Cast para garantir que 'validade' seja tratada como um objeto Carbon (Data)
    // Isso permite usar ->format('Y-m-d') na View sem erros
    protected $casts = [
        'validade' => 'date',
    ];
}