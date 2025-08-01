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
        Schema::create('clips', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('twitch_clip_id')->unique();
            $table->string('title');
            $table->string('embed_url');
            $table->string('thumbnail_url');
            $table->unsignedInteger('views')->default(0);
            $table->string('clipper_twitch_id');
            $table->string('clipper_name');
            $table->string('broadcaster_twitch_id');
            $table->string('broadcaster_name');
            $table->string('broadcaster_profile_image_url')->nullable();
            $table->string('clipper_profile_image_url')->nullable();

            $table->foreignUuid('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clips');
    }
};