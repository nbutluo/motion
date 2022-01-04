<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetaKeywordsToCatalogCategoryTable extends Migration
{
    public function up()
    {
        Schema::table('catalog_category', function (Blueprint $table) {
            $table->string('meta_keywords')->nullable()->after('meta_description');
        });
    }

    public function down()
    {
        Schema::table('catalog_category', function (Blueprint $table) {
            $table->dropColumn('meta_keywords');
        });
    }
}
