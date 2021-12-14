<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetaTitleAndMetaDescToCatalogCategoryTable extends Migration
{
    public function up()
    {
        Schema::table('catalog_category', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('is_active');
            $table->string('meta_description')->nullable()->after('meta_title');
        });
    }

    public function down()
    {
        Schema::table('catalog_category', function (Blueprint $table) {
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
        });
    }
}
