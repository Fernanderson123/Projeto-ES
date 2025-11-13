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
        'perfil',
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

    // ... (código existente) ...

    /**
     * Verifica se o usuário é um Administrador.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->perfil === 'Admin';
    }

    /**
     * Verifica se o usuário é uma Recepcionista.
     *
     * @return bool
     */
    public function isRecepcionista(): bool
    {
        return $this->perfil === 'Recepcionista';
    }

    /**
     * Verifica se o usuário é um Veterinário.
     *
     * @return bool
     */
    public function isVeterinario(): bool
    {
        return $this->perfil === 'Veterinário';
    }

    /**
     * Verifica se o usuário é um Investidor.
     *
     * @return bool
     */
    public function isInvestidor(): bool
    {
        return $this->perfil === 'Investidor';
    }

    /**
     * Verifica se o usuário é um Cliente.
     *
     * @return bool
     */
    public function isCliente(): bool
    {
        return $this->perfil === 'Cliente';
    }
}
