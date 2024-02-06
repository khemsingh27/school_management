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
        Schema::create('teacher__attendance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('attendence_type');
            $table->foreign('teacher_id')->references('id')->on('teachers'); 
            $table->foreign('school_id')->references('id')->on('schools');   
            $table->foreign('class_id')->references('id')->on('classes');
            $table->foreign('attendence_type')->references('id')->on('attendence_type');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher__attendance');
    }
};
