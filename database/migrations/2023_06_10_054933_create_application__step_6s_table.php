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
        Schema::create('application__step_6s', function (Blueprint $table) {
            $table->id();
            $table->integer('application_id')->nullable();
            $table->string('interview_date')->nullable();
            $table->string('interview_time')->nullable();
            $table->text('results')->nullable();
            $table->string('show')->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application__step_6s');
    }
};
