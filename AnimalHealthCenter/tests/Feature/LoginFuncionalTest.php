<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class LoginFuncionalTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function ct01_login_com_sucesso()
    {
        $user = User::factory()->create([
            'email' => 'admin@email.com',
            'password' => bcrypt('123456'),
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@email.com',
            'password' => '123456',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    #[Test]
    public function ct02_bloquear_acesso_sem_login()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    #[Test]
    public function ct03_login_com_senha_incorreta()
    {
        $user = User::factory()->create(['email' => 'user@teste.com']);

        $response = $this->post('/login', [
            'email' => 'user@teste.com',
            'password' => 'senha-errada',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}