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
        Schema::create('course_groups', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('intake')->nullable();
            $table->integer('course_intake_id')->nullable();
            $table->string('total_students')->nullable();
            $table->text('attend')->nullable();
            $table->text('absent')->nullable();
            $table->text('leave')->nullable();
            $table->text('group_performance')->nullable();
            $table->text('comments')->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_groups');
    }
};
