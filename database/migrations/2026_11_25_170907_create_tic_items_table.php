<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tic_items', function (Blueprint $table) {
            $table->id();
            $table->string('equipment_name');
            $table->string('location')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->integer('quantity')->default(1);
            $table->string('status')->default('Bueno');
            $table->text('specs')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tic_items');
    }
};