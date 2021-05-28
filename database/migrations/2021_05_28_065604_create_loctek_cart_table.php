<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoctekCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loctek_cart', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->Increments('id');
            $table->integer('product_id')->default(0)->comment('Product ID');
            $table->integer('user_id')->nullable()->comment('');
            $table->integer('qty')->default(0)->comment('');
            $table->string('options')->default('')->comment('Option Ids');
            $table->string('token')->default('')->comment('Token');
            $table->softDeletes();
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
        Schema::dropIfExists('loctek_cart');
    }
}
