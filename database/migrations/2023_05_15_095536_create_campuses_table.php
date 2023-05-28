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
        Schema::create('campuses', function (Blueprint $table) {
            $table->id();
            $table->string('country')->nullable();
            $table->text('slug')->nullable();
            $table->string('campus_name')->nullable();
            $table->string('website')->nullable();
            $table->string('monthly_living_cost')->nullable();
            $table->longText('funds_requirements_for_visa')->nullable();
            $table->string('application_fee')->nullable();
            $table->string('currency')->nullable();
            $table->string('is_lang_mendatory')->nullable();
            $table->longText('lang_requirements')->nullable();
            $table->longText('institute_benifits')->nullable();
            $table->longText('per_time_work_details')->nullable();
            $table->longText('scholarship_policy')->nullable();
            $table->longText('institute_important_notes')->nullable();
            $table->string('institute_logo')->nullable();
            $table->string('institute_prospectus')->nullable();
            $table->string('institute_course_pdf')->nullable();
            $table->boolean('active')->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campuses');
    }
};
