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
        Schema::create('qualifications', function (Blueprint $table) {
            $table->id();
            $table->integer('application_id')->nullable();
            $table->string('name_of_qualification')->nullable();
            $table->string('name_of_institute')->nullable();
            $table->string('awarding_organization')->nullable();
            $table->string('grade')->nullable();
            $table->string('year_of_completion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qualifications');
    }
};
