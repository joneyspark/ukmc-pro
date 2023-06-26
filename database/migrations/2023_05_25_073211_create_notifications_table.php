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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('create_date')->nullable();
            $table->integer('create_by')->nullable();
            $table->text('creator_image')->nullable();
            $table->string('creator_name')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('manager_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->integer('application_id')->default(0)->nullable();
            $table->tinyInteger('status')->nullable()->default(0);
            $table->tinyInteger('is_admin')->nullable()->default(0);
            $table->tinyInteger('is_view')->nullable()->default(0);
            $table->text('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
