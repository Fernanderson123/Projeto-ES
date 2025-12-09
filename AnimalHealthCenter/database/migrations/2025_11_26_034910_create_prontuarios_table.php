<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prontuarios', function (Blueprint $table) {
            $table->id();
            
            // Vínculo com o Paciente (Pet)
            $table->foreignId('pet_id')->constrained('pets')->onDelete('cascade');
            
            // Vínculo com o Veterinário que atendeu
            $table->foreignId('veterinario_id')->nullable()->constrained('users')->onDelete('set null');
            
            // (Opcional) Vínculo com o Agendamento que gerou este atendimento
            $table->foreignId('agendamento_id')->nullable()->constrained('agendamentos')->onDelete('set null');

            // Data do atendimento (padrão hoje)
            $table->date('data_atendimento')->useCurrent();
            
            $table->text('sintomas');
            $table->text('diagnostico')->nullable();
            $table->text('tratamento')->nullable();
            $table->text('observacoes')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prontuarios');
    }
};