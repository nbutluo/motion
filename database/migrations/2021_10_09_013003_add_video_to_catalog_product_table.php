<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVideoToCatalogProductTable extends Migration
{
    public function up()
    {
        Schema::table('catalog_product', function (Blueprint $table) {
            $table->string('video_url')->nullable()->after('small_image_label');
            $table->string('video_poster')->nullable()->after('video_url');
        });
    }

    public function down()
    {
        Schema::table('catalog_product', function (Blueprint $table) {
            $table->dropColumn('video_url');
            $table->dropColumn('video_poster');
        });
    }
}
