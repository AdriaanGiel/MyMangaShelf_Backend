<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reading_spots_uses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reading_spot_id')->constrained('reading_spots')->cascadeOnDelete();
            $table->foreignId('media_id')->constrained('media')->cascadeOnDelete();
            $table->integer('rating')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'reading_spot_id', 'media_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reading_spots_uses');
    }
};
