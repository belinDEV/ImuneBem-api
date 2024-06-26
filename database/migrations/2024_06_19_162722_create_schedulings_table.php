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
            $table->unsignedBigInteger('professional_id')->nullable();
            $table->unsignedBigInteger('vaccines_id')->nullable();
            $table->unsignedBigInteger('status_id')->default(1);
            $table->date('date');
            $table->integer('type', false, false);
            $table->string('description', 60);

            $table->foreign('patient_id')->references('id')->on('patients');
            //Vai ligar com os users do tipo 0
            $table->foreign('professional_id')->references('id')->on('users');
            $table->foreign('vaccines_id')->references('id')->on('vaccines');
            $table->foreign('status_id')->references('id')->on('statuses');
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
