<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSetProductIdsToCatalogProductTable extends Migration
{
    public function up()
    {
        Schema::table('catalog_product', function (Blueprint $table) {
            $table->string('set_product_ids')->nullable()->after('relate_ids');
        });
    }

    public function down()
    {
        Schema::table('catalog_product', function (Blueprint $table) {
            $table->dropColumn('set_product_ids');
        });
    }
}
