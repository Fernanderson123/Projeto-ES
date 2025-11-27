<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'perfil', // 'Admin', 'Veterinário', 'Recepcionista', 'Investidor', 'Cliente'
    ];
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- RELACIONAMENTOS (O que faltava) ---

    /**
     * Um usuário pode ter um perfil de Cliente associado.
     */
    public function cliente()
    {
        return $this->hasOne(Cliente::class);
    }
    
    /**
     * Um usuário (se for Veterinário) pode ter vários agendamentos.
     */
    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class, 'veterinario_id');
    }

    // --- HELPER FUNCTIONS (Já existentes) ---

    public function isAdmin(): bool
    {
        return $this->perfil === 'Admin';
    }

    public function isRecepcionista(): bool
    {
        return $this->perfil === 'Recepcionista';
    }

    public function isVeterinario(): bool
    {
        return $this->perfil === 'Veterinário';
    }

    public function isInvestidor(): bool
    {
        return $this->perfil === 'Investidor';
    }

    public function isCliente(): bool
    {
        return $this->perfil === 'Cliente';
    }
}