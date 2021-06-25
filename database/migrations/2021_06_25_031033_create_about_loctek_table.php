<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutLoctekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about_loctek', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->Increments('id');
            $table->tinyInteger('type')->nullable()->comment('message type : 1 pageMessage , 2 showMessage');
            $table->string('title')->nullable()->comment('Title');
            $table->text('content')->nullable()->comment('Content');
            $table->string('media_lable')->nullable()->comment('Media Lable');
            $table->tinyInteger('media_type')->default(1)->comment('Media Type');
            $table->string('media_link')->nullable()->comment('Media Link');
            $table->tinyInteger('is_active')->default(1)->comment('Is Active 0:no,1:yes');
            $table->tinyInteger('position')->default(0)->comment('Position');
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
        Schema::dropIfExists('about_loctek');
    }
}
