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
        Schema::create('course_intakes', function (Blueprint $table) {
            $table->id();
            $table->integer('course_id')->nullable();
            $table->string('title')->nullable();
            $table->string('intake_date')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_intakes');
    }
};
