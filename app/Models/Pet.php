<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id', 'nome', 'especie', 'raca', 'peso', 'data_nascimento',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Esta função mágica busca o agendamento mais recente que foi CONCLUÍDO
    public function ultimoAtendimento()
    {
        return $this->hasOne(Agendamento::class)
                    ->where('status', 'Concluído')
                    ->latest('data_hora');
    }
}