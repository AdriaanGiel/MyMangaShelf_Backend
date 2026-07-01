<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_provider', function (Blueprint $table) {
            $table->id();
            $table->string("media_uri")->nullable();
            $table->foreignId('media_id')->constrained('media')->cascadeOnDelete();
            $table->foreignId('provider_id')->constrained('providers')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['media_id', 'provider_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_provider');
    }
};
