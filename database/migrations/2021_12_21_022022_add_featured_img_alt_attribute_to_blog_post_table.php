<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeaturedImgAltAttributeToBlogPostTable extends Migration
{
    public function up()
    {
        Schema::table('blog_post', function (Blueprint $table) {
            $table->string('featured_img_alt')->nullable()->after('featured_img');
        });
    }

    public function down()
    {
        Schema::table('blog_post', function (Blueprint $table) {
            $table->dropColumn('featured_img_alt');
        });
    }
}
