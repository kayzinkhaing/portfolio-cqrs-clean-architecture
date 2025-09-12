<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('path');           // File path or URL
            $table->string('alt')->nullable(); // Original file name or alt text
            $table->string('type');           // 'image' or 'video'
            $table->boolean('is_primary')->default(false);
            $table->morphs('mediable');       // mediable_id + mediable_type
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
