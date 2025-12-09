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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            // Vínculo com o Cliente (Dono)
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            
            $table->string('nome');
            $table->string('especie'); // Cachorro, Gato, etc.
            $table->string('raca')->nullable();
            $table->decimal('peso', 5, 2)->nullable(); // Ex: 12.50
            $table->date('data_nascimento')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
