<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imagenes_producto', function (Blueprint $table) {
            $table->id('id_imagen');
            $table->foreignId('id_producto')
                  ->constrained('productos', 'id_producto')
                  ->cascadeOnDelete();
            $table->string('url_imagen');
            $table->integer('orden')->default(0);
            $table->timestamps();
        });
    }
     public function down(): void
    {
        Schema::dropIfExists('imagenes_producto');
    }

  
};