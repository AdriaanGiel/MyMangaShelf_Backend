<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_provider_chapter_list', function (Blueprint $table) {
            $table->id();
            $table->foreignId('media_provider_id')->constrained('media_provider')->cascadeOnDelete();
            $table->foreignId('chapter_list_id')->constrained('chapter_lists')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['media_provider_id', 'chapter_list_id'], 'mpcl_mpid_clid_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_provider_chapter_list');
    }
};
