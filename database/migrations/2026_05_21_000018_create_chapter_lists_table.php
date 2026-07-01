<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chapter_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('chapter');
            $table->foreignId('media_provider_id')->constrained('media_provider')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chapter_lists');
    }
};
