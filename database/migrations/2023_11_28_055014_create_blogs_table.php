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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->longText('long_description')->nullable();
            $table->integer('blog_category_id')->nullable();
            $table->text('author_name')->nullable();
            $table->text('author_image')->nullable();
            $table->text('blog_status')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('publish_time')->nullable();
            $table->text('alt_tag')->nullable();
            $table->text('image')->nullable();
			$table->text('slug')->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
