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
        Schema::table('video_files', function (Blueprint $table) {
            if (! Schema::hasColumn('video_files', 'size_bytes')) {
                $table->unsignedBigInteger('size_bytes')->nullable()->after('path');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('video_files', function (Blueprint $table) {
            if (Schema::hasColumn('video_files', 'size_bytes')) {
                $table->dropColumn('size_bytes');
            }
        });
    }
};
