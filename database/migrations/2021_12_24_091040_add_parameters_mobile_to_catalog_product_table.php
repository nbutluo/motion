<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParametersMobileToCatalogProductTable extends Migration
{
    public function up()
    {
        Schema::table('catalog_product', function (Blueprint $table) {
            $table->longText('parameters_mobile')->nullable()->after('parameters');
        });
    }

    public function down()
    {
        Schema::table('catalog_product', function (Blueprint $table) {
            $table->dropColumn('parameters_mobile');
        });
    }
}
