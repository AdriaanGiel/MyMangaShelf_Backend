<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reading_spots', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('media_id')->constrained('media')->cascadeOnDelete();
            $table->string('location');
            $table->string('image')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reading_spots');
    }
};
