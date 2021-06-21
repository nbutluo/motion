<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitemapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sitemap', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->tinyInteger('type')->default(1)->comment('Url type：1:fixed，2:dynamic');
            $table->tinyInteger('method')->default(1)->comment('Method Type：1:GET,2:POST');
            $table->string('name')->nullable()->comment('Url Name');
            $table->string('url')->unique()->comment('Url');
            $table->string('origin')->unique()->comment('Origin');
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
        Schema::dropIfExists('sitemap');
    }
}
