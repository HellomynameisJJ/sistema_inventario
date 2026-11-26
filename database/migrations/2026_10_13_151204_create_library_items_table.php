<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('library_items', function (Blueprint $table) {
            $table->id();
            $table->string('identificador')->nullable(); // p. ej. 000 GENERALIDADES / 1 / 2...
            $table->string('denominacion');              // Título o nombre del libro
            $table->string('coleccion')->nullable();     // TOMO 1, VOLUMEN I, etc.
            $table->integer('cantidad')->default(1);     // Cantidad de ejemplares
            $table->string('autor')->nullable();         // Autor
            $table->string('editorial')->nullable();     // Editorial
            $table->string('anio_edicion')->nullable();  // Año de edición
            $table->string('estado')->default('Bueno');  // Bueno, Regular, Malo
            $table->text('observaciones')->nullable();   // Observaciones adicionales
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('library_items');
    }
};