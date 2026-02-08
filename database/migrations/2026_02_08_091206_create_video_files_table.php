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
        Schema::create('video_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_id')->constrained()->onDelete('cascade');
            $table->string('quality'); // 240p,480p,720p,1080p
            $table->string('format')->default('hls'); // hls, mp4
            $table->string('path'); // s3/path/to/file.m3u8
            $table->bigInteger('size_bytes')->nullable();
            $table->timestamps();
             $table->unique(['video_id', 'quality', 'format']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_files');
    }
};
