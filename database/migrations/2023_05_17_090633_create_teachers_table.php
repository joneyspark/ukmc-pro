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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->integer('campus_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('teacher_name')->nullable();
            $table->string('teacher_phone')->nullable();
            $table->string('teacher_email')->nullable();
            $table->string('teacher_alternative_contact')->nullable();
            $table->string('teacher_nid_or_passport')->nullable();
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
        Schema::dropIfExists('teachers');
    }
};
