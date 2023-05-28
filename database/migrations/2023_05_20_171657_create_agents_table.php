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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->integer('campus_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('agent_name')->nullable();
            $table->string('agent_phone')->nullable();
            $table->string('agent_email')->nullable();
            $table->string('alternative_person_contact')->nullable();
            $table->string('nid_or_passport')->nullable();
            $table->string('nationality')->nullable();
            $table->string('agent_country')->nullable();
            $table->string('agent_state')->nullable();
            $table->string('agent_city')->nullable();
            $table->string('agent_zip_code')->nullable();
            $table->text('agent_address')->nullable();
            $table->text('image')->nullable();
            $table->tinyInteger('status')->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
