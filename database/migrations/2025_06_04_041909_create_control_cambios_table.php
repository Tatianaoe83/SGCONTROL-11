<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('control_cambios', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('nombre_documento');
            $table->string('tipo_documento');
            $table->string('proceso');
            $table->text('descripcion_cambio')->nullable();
            $table->text('justificacion')->nullable();
            $table->date('fecha');
            $table->string('elaboro')->nullable();
            $table->string('reviso')->nullable();
            $table->string('aprobo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('control_cambios');
    }
};
