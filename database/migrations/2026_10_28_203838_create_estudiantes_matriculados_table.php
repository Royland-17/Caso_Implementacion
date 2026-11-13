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
    Schema::create('estudiantes_matriculados', function (Blueprint $table) {
    $table->unsignedBigInteger('grupo_id');
    $table->string('carne');
    $table->float('nota')->nullable();

    $table->foreign('grupo_id')->references('id')->on('grupos')->onDelete('cascade');
    $table->foreign('carne')->references('carne')->on('estudiantes')->onDelete('cascade');

    $table->primary(['grupo_id', 'carne']);
    $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiante_matriculados');
    }
};
