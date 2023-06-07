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
        Schema::create('application__step_2s', function (Blueprint $table) {
            $table->id();
            $table->integer('application_id')->nullable();
            $table->string('nationality')->nullable();
            $table->string('other_nationality')->nullable();
            $table->string('ethnic_origin')->nullable();
            $table->string('country')->nullable();
            $table->string('highest_qualification_entry')->nullable();
            $table->string('highest_qualification')->nullable();
            $table->string('last_institution_you_attended')->nullable();
            $table->string('unique_learner_number')->nullable();
            $table->string('name_of_qualification')->nullable();
            $table->string('you_obtained')->nullable();
            $table->string('subject')->nullable();
            $table->string('grade')->nullable();
            $table->string('passport_no')->nullable();
            $table->string('passport_expiry')->nullable();
            $table->string('passport_place')->nullable();
            $table->string('spent_public_care')->nullable();
            $table->string('disability')->nullable();
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
            $table->string('kin_name')->nullable();
            $table->string('kin_relation')->nullable();
            $table->string('kin_email')->nullable();
            $table->string('kin_phone')->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application__step_2s');
    }
};
