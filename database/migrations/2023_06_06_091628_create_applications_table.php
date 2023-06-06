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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id')->default(0)->nullable();
            $table->string('applicant_fees_funded')->nullable();
            $table->string('current_residential_status')->nullable();
            $table->integer('campus_id')->nullable();
            $table->integer('course_id')->nullable();
            $table->string('local_course_fee')->nullable();
            $table->string('international_course_fee')->nullable();
            $table->string('course_program')->nullable();
            $table->string('intake')->nullable();
            $table->string('course_level')->nullable();
            $table->string('delivery_pattern')->nullable();
            $table->string('title')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('is_applying_advanced_entry')->nullable();
            $table->integer('admission_officer_id')->default(0)->nullable();
            $table->tinyInteger('application_status_id')->default(0)->nullable();
            $table->tinyInteger('is_final_interview')->default(0)->nullable();
            $table->integer('create_by')->nullable();
            $table->integer('update_by')->nullable();
            $table->string('steps')->nullable();
            $table->tinyInteger('application_process_status')->default(0)->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->tinyInteger('is_deleted')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
