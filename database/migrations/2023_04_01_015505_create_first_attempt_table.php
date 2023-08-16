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
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->string('route', 80);
            $table->integer('sort_number');
            $table->string('icon');

        });

        Schema::create('admin_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('admin', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admin_groups_id');
            $table->string('fullname', 45);
            $table->string('email', 100);
            $table->string('password', 100);
            $table->text('token')->nullable();
            $table->integer('is_active');
            $table->timestamps();

            $table->foreign('admin_groups_id')->references('id')->on('admin_groups')->onDelete('cascade');
        });

        Schema::create('authorization_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('authorizations', function (Blueprint $table) {
            $table->unsignedInteger('admin_groups_id');
            $table->unsignedInteger('authorization_types_id');
            $table->unsignedInteger('menus_id');

            $table->foreign('admin_groups_id')->references('id')->on('admin_groups')->onDelete('cascade');
            $table->foreign('authorization_types_id')->references('id')->on('authorization_types')->onDelete('cascade');
            $table->foreign('menus_id')->references('id')->on('menus')->onDelete('cascade');
        });

        Schema::create('banners', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->text('cover_image_path');
            $table->text('thumbnail_image_path');
            $table->text('redirect_link')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('web_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->text('about_us');
            $table->text('promotional_video_link');
            $table->text('contact_us');
            $table->text('embedded_twitter');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('social_media', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->text('logo');
            $table->text('link');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->text('cover_image');
            $table->text('color_background');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authorizations');
        Schema::dropIfExists('menus');
        Schema::dropIfExists('admin');
        Schema::dropIfExists('admin_groups');
        Schema::dropIfExists('authorization_types');
        Schema::dropIfExists('banners');
        Schema::dropIfExists('web_profiles');
        Schema::dropIfExists('social_media');
    }
};
