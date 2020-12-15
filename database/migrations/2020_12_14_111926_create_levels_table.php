<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index()->comment('授权名称');
            $table->tinyInteger('value')->comment('权限判断值');
        });
    }


    public function down()
    {
        Schema::dropIfExists('levels');
    }
}
