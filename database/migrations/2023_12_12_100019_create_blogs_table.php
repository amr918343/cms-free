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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->unsignedBigInteger('views')->default(0);
            $table->longText('title');
            $table->longText('desc');
            $table->unsignedBigInteger('order')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('last_viewed_at')->nullable();
            $table->timestamp('type')->nullable();
            $table->text('img')->nullable();
            $table->text('alt_img')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
