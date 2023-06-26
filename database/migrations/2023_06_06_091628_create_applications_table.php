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

            $table->string('reference')->nullable();
            $table->string('title')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('name')->nullable();
            $table->string('gender')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('ni_number')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_number')->nullable();

            $table->string('house_number')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('address_country')->nullable();
			$table->string('same_as')->nullable();
            $table->string('current_house_number')->nullable();
            $table->string('current_address_line_2')->nullable();
            $table->string('current_city')->nullable();
            $table->string('current_state')->nullable();
            $table->string('current_postal_code')->nullable();
            $table->string('current_country')->nullable();
            $table->string('nationality')->nullable();
            $table->string('other_nationality')->nullable();
            $table->string('visa_category')->nullable();
            $table->string('date_entry_of_uk')->nullable();
            $table->string('ethnic_origin')->nullable();

            $table->integer('university_id')->nullable();
            $table->integer('campus_id')->nullable();
            $table->integer('course_id')->nullable();
            $table->string('local_course_fee')->nullable();
            $table->string('international_course_fee')->nullable();
            $table->string('intake')->nullable();
            $table->string('delivery_pattern')->nullable();

            $table->text('slug')->nullable();

            $table->integer('admission_officer_id')->default(0)->nullable();
            $table->integer('marketing_officer_id')->default(0)->nullable();
            $table->integer('manager_id')->default(0)->nullable();

            $table->integer('is_academic')->default(1)->nullable();
            $table->tinyInteger('application_status_id')->default(0)->nullable();
            $table->tinyInteger('is_final_interview')->default(0)->nullable();
            $table->tinyInteger('app_process')->default(0)->nullable();
            $table->tinyInteger('is_written_test')->default(0)->nullable();
            $table->integer('create_by')->nullable();
            $table->integer('update_by')->nullable();
            $table->string('steps')->nullable();
            $table->tinyInteger('application_process_status')->default(0)->nullable();
            $table->tinyInteger('application_type')->default(0)->nullable();//1 for agent 2 for student 3 for direct application
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
