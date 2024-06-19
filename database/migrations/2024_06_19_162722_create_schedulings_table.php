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
        Schema::create('schedulings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('vaccines_id');
            $table->unsignedBigInteger('status_id'); // Nome da coluna corrigido
            $table->date('date');
            $table->string('description', 60);
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('vaccines_id')->references('id')->on('vaccines');
            $table->foreign('status_id')->references('id')->on('statuses'); // Nome da coluna corrigido
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedulings');
    }
};
