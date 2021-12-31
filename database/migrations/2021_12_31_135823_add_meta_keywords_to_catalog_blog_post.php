<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetaKeywordsToCatalogBlogPost extends Migration
{
    public function up()
    {
        Schema::table('blog_post', function (Blueprint $table) {
            $table->string('meta_keywords')->nullable()->after('meta_description');
        });
    }

    public function down()
    {
        Schema::table('blog_post', function (Blueprint $table) {
            $table->dropColumn('meta_keywords');
        });
    }
}
