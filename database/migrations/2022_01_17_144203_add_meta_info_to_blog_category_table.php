<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetaInfoToBlogCategoryTable extends Migration
{
    public function up()
    {
        Schema::table('blog_category', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('is_active');
            $table->string('meta_keywords')->nullable()->after('meta_title');
            $table->string('meta_description')->nullable()->after('meta_keywords');
        });
    }


    public function down()
    {
        Schema::table('blog_category', function (Blueprint $table) {
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_keywords');
            $table->dropColumn('meta_description');
        });
    }
}
