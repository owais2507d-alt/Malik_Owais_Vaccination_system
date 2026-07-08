<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('hospital_id')->constrained('hospitals')->onDelete('cascade');
            $table->string('type');
            $table->date('appointment_date');
            $table->string('status')->default('pending');
            $table->string('test_result')->default('pending');
            $table->string('vaccination_status')->default('not_vaccinated');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
