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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short')->nullable();
            $table->text('content')->nullable();
            $table->json('images')->nullable();
            $table->text('thumbnail')->nullable();
            $table->json('custom_fields')->nullable();
            $table->bigInteger('views')->default(1);
            $table->boolean('is_enabled')->default(false);
            $table->string('type')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_text_keys')->nullable();
            $table->string('seo_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
