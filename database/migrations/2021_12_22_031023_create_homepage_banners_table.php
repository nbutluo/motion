<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomepageBannersTable extends Migration
{
    public function up()
    {
        Schema::create('homepage_banners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description')->nullable();
            $table->string('media_url_pc');
            $table->string('media_url_mobile');
            $table->string('banner_alt')->nullable();
            $table->integer('order')->nullable();
            $table->string('link_url')->nullable();
            $table->boolean('is_active')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('homepage_banners');
    }
}
