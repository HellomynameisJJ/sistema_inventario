<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('library_items', function (Blueprint $table) {
            if (Schema::hasColumn('library_items', 'title')) {
                $table->string('title')->nullable()->change();
            }
            if (!Schema::hasColumn('library_items', 'identificador')) {
                $table->string('identificador')->nullable();
            }
            if (!Schema::hasColumn('library_items', 'denominacion')) {
                $table->string('denominacion')->nullable();
            }
            if (!Schema::hasColumn('library_items', 'coleccion')) {
                $table->string('coleccion')->nullable();
            }
            if (!Schema::hasColumn('library_items', 'autor')) {
                $table->string('autor')->nullable();
            }
            if (!Schema::hasColumn('library_items', 'editorial')) {
                $table->string('editorial')->nullable();
            }
            if (!Schema::hasColumn('library_items', 'anio_edicion')) {
                $table->string('anio_edicion')->nullable();
            }
            if (!Schema::hasColumn('library_items', 'estado')) {
                $table->string('estado')->default('Bueno');
            }
            if (!Schema::hasColumn('library_items', 'observaciones')) {
                $table->text('observaciones')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('library_items', function (Blueprint $table) {
            if (Schema::hasColumn('library_items', 'title')) {
                $table->string('title')->nullable(false)->change();
            }
        });
    }
};