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

    protected $casts = [
        'data_hora' => 'datetime', // Facilita formatação de data
    ];

    // Relacionamento: Pertence a um Pet
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    // Relacionamento: Pertence a um Veterinário (User)
    public function veterinario()
    {
        return $this->belongsTo(User::class, 'veterinario_id');
    }
}