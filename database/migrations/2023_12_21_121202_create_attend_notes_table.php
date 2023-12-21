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
        Schema::create('attend_notes', function (Blueprint $table) {
            $table->id();
            $table->integer('application_id')->nullable();
            $table->integer('schedule_id')->nullable();
            $table->text('note')->nullable();
            $table->integer('user_id')->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attend_notes');
    }
};
