<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'veterinario_id',
        'data_hora',
        'tipo',
        'status',
        'observacoes',
    ];

    // Garante que o Laravel entenda 'data_hora' como Data e Hora, não texto
    protected $casts = [
        'data_hora' => 'datetime',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function veterinario()
    {
        return $this->belongsTo(User::class, 'veterinario_id');
    }
}