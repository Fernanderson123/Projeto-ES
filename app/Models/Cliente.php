<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nome_completo',
        'cpf',
        'telefone',
        'email',
        'endereco_cep',
        'endereco_rua',
        'endereco_numero',
        'endereco_bairro',
        'endereco_cidade',
        'endereco_estado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento: Um Cliente tem muitos Pets
    public function pets()
    {
        return $this->hasMany(Pet::class);
    }
}