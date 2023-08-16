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
        Schema::create('menu_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45);
            $table->timestamps();
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->unsignedInteger('menu_groups_id')->nullable();

            $table->foreign('menu_groups_id')->references('id')->on('menu_groups')->onDelete('cascade');
        });

        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn('redirect_link');
            $table->integer('order')->after('thumbnail_image_path')->change();
            $table->integer('status')->after('thumbnail_image_path')->default(1)->change();
            $table->unsignedInteger('games_id')->nullable();

            $table->foreign('games_id')->references('id')->on('games')->onDelete('cascade');
        });

        Schema::table('games', function (Blueprint $table) {
            $table->text('description')->after('name')->nullable();
            $table->integer('order')->after('name')->change();
            $table->integer('status')->after('color_background')->default(1)->change();
            $table->text('small_icon')->after('redirect_link')->nullable();
            $table->text('web_background_image')->after('redirect_link')->nullable();
        });

        Schema::table('web_profiles', function (Blueprint $table) {
            $table->dropColumn('promotional_video_link');
        });

        Schema::create('promotional_videos', function (Blueprint $table) {
            $table->increments('id');
            $table->text('link');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('game_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->text('link');
            $table->unsignedInteger('games_id')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('games_id')->references('id')->on('games')->onDelete('cascade');
        });

        Schema::create('game_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('game_has_game_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('games_id');
            $table->unsignedInteger('game_categories_id');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('games_id')->references('id')->on('games')->onDelete('cascade');
            $table->foreign('game_categories_id')->references('id')->on('game_categories')->onDelete('cascade');
        });

        Schema::create('game_download_links', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45);
            $table->unsignedInteger('games_id');
            $table->text('redirect_link');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('games_id')->references('id')->on('games')->onDelete('cascade');
        });

        Schema::create('game_system_requirement', function (Blueprint $table) {
            $table->increments('id');
            $table->text('min_os');
            $table->text('min_processor');
            $table->text('min_memory');
            $table->text('min_graphics');
            $table->text('min_storage');
            $table->text('rec_os');
            $table->text('rec_processor');
            $table->text('rec_memory');
            $table->text('rec_graphics');
            $table->text('rec_storage');
            $table->unsignedInteger('games_id');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('games_id')->references('id')->on('games')->onDelete('cascade');
        });

        Schema::create('game_news_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('game_news', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->text('body')->nullable();
            $table->text('cover_image')->nullable();
            $table->unsignedInteger('admins_id');
            $table->unsignedInteger('game_news_categories_id');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('admins_id')->references('id')->on('admin')->onDelete('cascade');
            $table->foreign('game_news_categories_id')->references('id')->on('game_news_categories')->onDelete('cascade');
        });

        Schema::create('blog_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('blogs', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->text('body')->nullable();
            $table->text('cover_image')->nullable();
            $table->unsignedInteger('admins_id');
            $table->unsignedInteger('blog_categories_id');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('admins_id')->references('id')->on('admin')->onDelete('cascade');
            $table->foreign('blog_categories_id')->references('id')->on('blog_categories')->onDelete('cascade');
        });

        Schema::create('hashtags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('blog_has_hashtags', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('blogs_id');
            $table->unsignedInteger('hashtags_id');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('blogs_id')->references('id')->on('blogs')->onDelete('cascade');
            $table->foreign('hashtags_id')->references('id')->on('hashtags')->onDelete('cascade');
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
