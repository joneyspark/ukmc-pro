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
        Schema::create('class_schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('course_id')->nullable();
            $table->integer('intake_id')->nullable();
            $table->integer('subject_id')->nullable();
            $table->string('intake_date')->nullable();
            $table->string('title')->nullable();
            $table->string('schedule_date')->nullable();
            $table->string('time_from')->nullable();
            $table->string('time_to')->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->tinyInteger('is_done')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_schedules');
    }
};
