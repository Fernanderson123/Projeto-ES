<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            
            // Pet (Paciente)
            $table->foreignId('pet_id')->constrained('pets')->onDelete('cascade');
            
            // Veterinário (Quem vai atender)
            $table->foreignId('veterinario_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Data e Hora
            $table->dateTime('data_hora');
            
            // Tipo (Consulta, Vacina, Cirurgia)
            $table->string('tipo');
            
            // Status (Agendado, Concluído, Cancelado)
            $table->string('status')->default('Agendado');
            
            $table->text('observacoes')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendamentos');
    }
};