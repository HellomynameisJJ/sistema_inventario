<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laboratory_items', function (Blueprint $table) {
            $table->id();
            $table->string('item')->nullable();
            $table->string('codigo_interno')->nullable();
            $table->string('denominacion_tecnica');
            $table->text('descripcion_tecnica')->nullable();
            $table->integer('cantidad')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laboratory_items');
    }
};