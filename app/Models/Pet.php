<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'nome',
        'especie',
        'raca',
        'peso',
        'data_nascimento',
    ];

    // Relacionamento: Um Pet pertence a um Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}