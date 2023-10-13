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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->longtext('caption')->nullable();
            $table->string('image')->nullable();
            $table->integer('like')->default(0);
            $table->integer('share')->default(0);
            $table->integer('type')->default(0);
            $table->integer('shared_post_id')->nullable();
            $table->integer('shared_user_id')->nullable();
            $table->longtext('shared_caption')->nullable();
            $table->text('video')->nullable();
            $table->integer('group_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
