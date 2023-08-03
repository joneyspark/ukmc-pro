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
        Schema::create('application_sops', function (Blueprint $table) {
            $table->id();
            $table->longText('sop_data')->nullable();
            $table->integer('application_id')->nullable();
            $table->string('total_queries')->nullable();
            $table->string('plag_percent')->nullable();
            $table->string('paraphrase_percent')->nullable();
            $table->string('unique_percent')->nullable();
            $table->longText('total_plag_data')->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_sops');
    }
};
