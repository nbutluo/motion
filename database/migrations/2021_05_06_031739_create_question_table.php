<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->integer('user_id')->default(0)->comment('User ID');
            $table->integer('category_id')->default(0)->comment('Category ID');
            $table->integer('product_id')->default(0)->comment('Product ID');
            $table->string('title')->nullable()->comment('Title');
            $table->text('short_content')->nullable()->comment('Short Content');
            $table->mediumText('content')->nullable()->comment('Content');
            $table->tinyInteger('is_active')->default(0)->comment('0:No 1:Yes');
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
        Schema::dropIfExists('question');
    }
}
