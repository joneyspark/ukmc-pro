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
        Schema::create('followups', function (Blueprint $table) {
            $table->id();
            $table->integer('application_id')->nullable();
            $table->text('follow_up')->nullable();
            $table->string('follow_up_date_time')->nullable();
            $table->tinyInteger('is_follow_up_done')->default(0)->nullable();
            $table->tinyInteger('is_notified')->default(0)->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followups');
    }
};
