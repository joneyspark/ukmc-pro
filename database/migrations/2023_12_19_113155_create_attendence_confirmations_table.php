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
        Schema::create('attendence_confirmations', function (Blueprint $table) {
            $table->id();
            $table->integer('class_schedule_id')->nullable();
            $table->integer('application_id')->nullable();
            $table->integer('course_id')->nullable();
            $table->integer('intake_id')->nullable();
            $table->integer('subject_id')->nullable();
            $table->string('intake_date')->nullable();
            $table->tinyInteger('application_status')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendence_confirmations');
    }
};
