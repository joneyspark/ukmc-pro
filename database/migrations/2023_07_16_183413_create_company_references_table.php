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
        Schema::create('company_references', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('referee_name')->nullable();
            $table->string('referee_job_title')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('contact_email_address')->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_references');
    }
};
