<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome_completo');
            $table->string('cpf')->unique();
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->string('endereco_cep', 9)->nullable();
            $table->string('endereco_rua')->nullable();
            $table->string('endereco_numero')->nullable();
            $table->string('endereco_bairro')->nullable();
            $table->string('endereco_cidade')->nullable();
            $table->string('endereco_estado', 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};