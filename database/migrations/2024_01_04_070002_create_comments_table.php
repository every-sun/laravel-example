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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->longText('content');
            $table->string('writer')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('post_id');
            $table->foreign('post_id')->cascadeOnDelete()->references('id')->on('posts');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->cascadeOnDelete()->references('id')->on('users');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->cascadeOnDelete()->references('id')->on('comments');
            $table->enum('likes', ['']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
