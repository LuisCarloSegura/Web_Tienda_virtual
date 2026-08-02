<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id('id_factura');
            $table->foreignId('id_compra') ->unique()->constrained('compras', 'id_compra')->cascadeOnDelete();
            $table->string('numero_factura')->unique();
            $table->timestamp('fecha_emision')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};