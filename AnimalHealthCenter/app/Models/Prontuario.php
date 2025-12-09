<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prontuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'veterinario_id',
        'agendamento_id',
        'data_atendimento',
        'sintomas',
        'diagnostico',
        'tratamento',
        'observacoes',
    ];

    // Garante que o campo seja tratado como data (Carbon object)
    protected $casts = [
        'data_atendimento' => 'date',
    ];

    // --- Relacionamentos ---

    // O Prontuário pertence a um Pet (Paciente)
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    // O Prontuário foi registrado por um Veterinário (User)
    public function veterinario()
    {
        return $this->belongsTo(User::class, 'veterinario_id');
    }
    
    // O Prontuário pode estar ligado a um Agendamento específico
    public function agendamento()
    {
        return $this->belongsTo(Agendamento::class);
    }
}