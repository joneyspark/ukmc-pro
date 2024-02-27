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
        Schema::create('invite_unconditional_offers', function (Blueprint $table) {
            $table->id();
            $table->integer('application_id')->nullable();
            $table->text('link')->nullable();
            $table->text('reason')->nullable();
            $table->tinyInteger('accept')->default(0)->nullable();
            $table->tinyInteger('reject')->default(0)->nullable();
            $table->tinyInteger('deferred')->default(0)->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Schema::dropIfExists('invite_unconditional_offers');
    }
};
