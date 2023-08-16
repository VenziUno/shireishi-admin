<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->text('short_description')->nullable();
        });

        Schema::table('game_news', function (Blueprint $table) {
            $table->unsignedInteger('games_id')->nullable();

            $table->foreign('games_id')->references('id')->on('games')->onDelete('cascade');
        });

        Schema::create('blog_images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('blogs_id');
            $table->text('image_link');
            $table->text('caption')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('blogs_id')->references('id')->on('blogs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
