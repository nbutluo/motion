<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectoryCountryRegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directory_country_region', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->Increments('id');
            $table->string('country')->nullable()->comment('Country');
            $table->string('province')->nullable()->comment('Province');
            $table->string('city')->nullable()->comment('City');
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
        Schema::dropIfExists('directory_country_region');
    }
}
