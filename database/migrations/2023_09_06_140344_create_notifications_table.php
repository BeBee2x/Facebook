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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->integer('type');
            $table->integer('from_user_id');
            $table->integer('to_user_id');
            $table->integer('post_id')->nullable();
            $table->integer('group_id')->nullable();
            $table->text('group_image')->nullable();
            $table->integer('story_id')->nullable();
            $table->text('group_name')->nullable();
            $table->integer('comment_id')->nullable();
            $table->integer('reply_comment_id')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
