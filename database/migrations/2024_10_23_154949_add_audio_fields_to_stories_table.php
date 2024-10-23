<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->boolean('has_audio')->default(false);
            $table->string('audio_url', 512)->nullable();
        });
    }

    public function down()
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->dropColumn(['has_audio', 'audio_url']);
        });
    }
};