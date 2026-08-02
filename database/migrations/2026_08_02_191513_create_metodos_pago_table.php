<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('metodos_pago', function (Blueprint $table) {
            $table->id('id_metodo');
            $table->foreignId('id_usuario')
                  ->constrained('users', 'id_usuario')
                  ->cascadeOnDelete();
            $table->string('token_pasarela');
            $table->string('tipo'); // ej: "Visa **** 4242"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('metodos_pago');
    }
};