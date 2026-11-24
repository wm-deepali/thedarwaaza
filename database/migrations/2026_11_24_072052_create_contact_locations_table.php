<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_locations', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->text('address');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_locations');
    }
};