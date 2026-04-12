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
        // 1. Categories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type')->nullable(); // movie, show, etc
            $table->timestamps();
        });

        // 2. Genres
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // 3. Movies
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_id')->constrained()->onDelete('cascade');
            $table->boolean('is_premium')->default(false);
            $table->boolean('allow_download')->default(false);
            $table->timestamps();
        });

        // 4. TV Shows
        Schema::create('tv_shows', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('poster')->nullable();
            $table->string('thumbnail')->nullable();
            $table->text('description')->nullable();
            $table->string('rating')->nullable();
            $table->integer('year')->nullable();
            $table->timestamps();
        });

        // 5. Seasons
        Schema::create('seasons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tv_show_id')->constrained()->onDelete('cascade');
            $table->integer('season_number');
            $table->string('title')->nullable();
            $table->timestamps();
        });

        // 6. Episodes
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('season_id')->constrained()->onDelete('cascade');
            $table->foreignId('video_id')->constrained()->onDelete('cascade');
            $table->integer('episode_number');
            $table->string('name')->nullable();
            $table->string('thumbnail')->nullable();
            $table->timestamps();
        });

        // 7. Reels
        Schema::create('reels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // 8. View Histories
        Schema::create('view_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('video_id')->constrained()->onDelete('cascade');
            $table->integer('last_position_sec')->default(0);
            $table->timestamp('last_watched_at')->useCurrent();
            $table->timestamps();
        });

        // 9. Video Files
        Schema::create('video_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_id')->constrained()->onDelete('cascade');
            $table->string('quality'); // 1080p, 720p, etc
            $table->string('format')->default('mp4'); // mp4, hls, etc
            $table->string('path');
            $table->timestamps();
        });

        // 10. Subtitles
        Schema::create('subtitles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_id')->constrained()->onDelete('cascade');
            $table->string('language')->default('en');
            $table->string('path');
            $table->timestamps();
        });

        // 11. Pivot: genre_video
        Schema::create('genre_video', function (Blueprint $table) {
            $table->id();
            $table->foreignId('genre_id')->constrained()->onDelete('cascade');
            $table->foreignId('video_id')->constrained()->onDelete('cascade');
        });

        // 12. Pivot: category_video
        Schema::create('category_video', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('video_id')->constrained()->onDelete('cascade');
        });

        // 13. Live Channels
        Schema::create('live_channels', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('logo')->nullable();
            $table->string('category')->nullable();
            $table->boolean('is_premium')->default(false);
            $table->timestamps();
        });

        // 14. Live Streams
        Schema::create('live_streams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('live_channel_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('url');
            $table->string('quality')->default('HD');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 15. Blog Posts
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->string('banner')->nullable();
            $table->foreignId('author_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
        Schema::dropIfExists('live_streams');
        Schema::dropIfExists('live_channels');
        Schema::dropIfExists('category_video');
        Schema::dropIfExists('genre_video');
        Schema::dropIfExists('subtitles');
        Schema::dropIfExists('video_files');
        Schema::dropIfExists('view_histories');
        Schema::dropIfExists('reels');
        Schema::dropIfExists('episodes');
        Schema::dropIfExists('seasons');
        Schema::dropIfExists('tv_shows');
        Schema::dropIfExists('movies');
        Schema::dropIfExists('genres');
        Schema::dropIfExists('categories');
    }
};
