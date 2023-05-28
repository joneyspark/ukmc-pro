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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('assign_by')->nullable();
            $table->integer('assign_to')->nullable();
            $table->string('task_name')->nullable();
            $table->text('task_details')->nullable();
            $table->string('priority')->nullable();
            $table->text('doc')->nullable();
            $table->text('slug')->nullable();
            $table->timestamp('deadline')->nullable();
            $table->tinyInteger('is_view')->nullable()->default(0);
            $table->tinyInteger('status')->nullable()->default(0);
            $table->text('coments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
