<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsiteSeoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_seo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('seo_meta')->default('')->comment('SEO meta');
            $table->string('seo_content')->default('')->comment('SEO content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_seo');
    }
}
