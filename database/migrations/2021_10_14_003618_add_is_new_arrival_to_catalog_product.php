<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsNewArrivalToCatalogProduct extends Migration
{
    public function up()
    {
        Schema::table('catalog_product', function (Blueprint $table) {
            $table->boolean('is_new_arrival')->default(false)->after('is_active');
        });
    }

    public function down()
    {
        Schema::table('catalog_product', function (Blueprint $table) {
            $table->dropColumn('is_new_arrival');
        });
    }
}
