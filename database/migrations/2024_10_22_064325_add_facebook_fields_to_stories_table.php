<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->string('facebook_post_id')->nullable()->after('is_published');
            $table->boolean('is_published_to_facebook')->default(false)->after('facebook_post_id');
            $table->timestamp('facebook_published_at')->nullable()->after('is_published_to_facebook');
        });
    }

    public function down(): void
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->dropColumn([
                'facebook_post_id',
                'is_published_to_facebook',
                'facebook_published_at'
            ]);
        });
    }
};