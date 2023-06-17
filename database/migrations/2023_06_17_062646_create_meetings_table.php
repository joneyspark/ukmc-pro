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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->integer('application_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('meeting_date_time')->nullable();
            $table->tinyInteger('notified')->default(0)->nullable();
            $table->text('meeting_notes')->nullable();
            $table->tinyInteger('is_meeting_done')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
