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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->integer('campus_id')->nullable();
            $table->string('course_name')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('course_level_id')->nullable();
            $table->string('course_duration')->nullable();
            $table->string('course_fee')->nullable();
            $table->string('international_course_fee')->nullable();
            $table->text('course_intake')->nullable();
            $table->text('awarding_body')->nullable();
            $table->string('is_lang_mendatory')->nullable();
            $table->longText('lang_requirements')->nullable();
            $table->longText('per_time_work_details')->nullable();
            $table->text('addtional_info_course')->nullable();
            $table->text('course_prospectus')->nullable();
            $table->text('course_module')->nullable();
            $table->text('slug')->nullable();
            $table->integer('create_by')->nullable();
            $table->integer('update_by')->nullable();
            $table->tinyInteger('status')->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
