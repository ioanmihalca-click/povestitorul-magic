<?php

use App\StoryGenre;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title', 255);
            $table->text('content');
            $table->unsignedTinyInteger('age');
            $table->enum('genre', array_column(StoryGenre::cases(), 'value'));
            $table->string('theme');
            $table->string('image_url', 512)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'genre']);
            $table->index('age');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};