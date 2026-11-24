<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();
            $table->string('banner_title')->nullable();
            $table->string('about_heading')->nullable();
            $table->longText('about_content')->nullable();
            $table->string('about_image')->nullable();
            $table->string('why_heading')->nullable();
            $table->text('why_text')->nullable();
            $table->string('brochure_heading')->nullable();
            $table->text('brochure_text')->nullable();
            $table->string('brochure_image')->nullable();
            $table->string('brochure_link')->nullable();
            $table->string('process_heading')->nullable();
            $table->timestamps();
        });

        Schema::create('about_items', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20)->index();      // why | process
            $table->string('title')->nullable();
            $table->text('text')->nullable();
            $table->string('image')->nullable();      // why cards
            $table->string('icon')->nullable();       // process steps (icon class)
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_items');
        Schema::dropIfExists('about_pages');
    }
};