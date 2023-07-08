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
        Schema::create('interviewers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('interviewer_name')->nullable();
            $table->string('interviewer_phone')->nullable();
            $table->string('interviewer_email')->nullable();
            $table->string('interviewer_alternative_contact')->nullable();
            $table->string('interviewer_nid_or_passport')->nullable();
            $table->string('nationality')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->longText('other_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interviewers');
    }
};
