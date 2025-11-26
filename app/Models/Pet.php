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

    // --- NOVO: Relação para pegar a Última Ação ---
    public function ultimoAtendimento()
    {
        // Busca um agendamento que esteja 'Concluído', ordenado pelo mais recente
        return $this->hasOne(Agendamento::class)
                    ->where('status', 'Concluído')
                    ->latest('data_hora');
    }
}